<?php

namespace Source\App;

use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;
use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Brands\Brands;
use Source\Models\Category;
use Source\Models\Clients\ClientRepository;
use Source\Models\Clients\Clients;
use Source\Models\Enterprises\Enterprises;
use Source\Models\Faq\Question;
use Source\Models\Inventory\Inventory;
use Source\Models\Orders\CheckoutValidator;
use Source\Models\Orders\Installments\Installments;
use Source\Models\Orders\OrdersRepository;
use Source\Models\Post;
use Source\Models\Products\Products;
use Source\Models\ProductsCategories\ProductsCategories;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Pager;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");

        (new Access())->report();
        (new Online())->report();
    }

    /**
     * SITE HOME
     */
    public function home(?array $data): void
    {

        $products = (new Products())->findCustom("
        SELECT
	products.name, 
	products.image, 
	products.price, 
	products.url, 
	inventory.product_id, 
	inventory.amount, 
	products.id
FROM
	products,
	inventory
WHERE
	inventory.amount >= 1 AND products.id = inventory.product_id
	AND products.status = 'active'  AND products.price > 0  ");


        $pager = new Pager(url("/"));
        $pager->pager($products->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("home", [
            "head" => $head,
            "enterprise" => $this->enterprise(),
            "paginator" => $pager->render(),
            "products" => $products->order("products.id")->limit($pager->limit())->offset($pager->offset())->fetch(true),
        ]);
    }


    //RETORNA OS DADOS DA EMPRESA
    public function enterprise()
    {
        $enterpise = (new Enterprises())->findById(1);
        return $_SESSION["enterprise"] = $enterpise;
    }


    /**
     ************************************
     ************SINGLE PAGE MODAL
     ***********************************/
    public function single(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $productId = filter_var($data['productId'], FILTER_SANITIZE_STRIPPED);
        $product = (new Products)->findById($productId);
        $inventory = (new Inventory())->find("product_id = :i GROUP BY product_id ", "i={$productId}")->fetch(true);

        $category = (new ProductsCategories())->find("id = :p", "p={$product->category_id}", "category")->fetch();
        $brand = (new Brands())->find("id = :p", "p={$product->brand_id}", "name")->fetch();


        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("modal", [
            "head" => $head,
            "product" => $product,
            "category" => $category,
            "brand" => $brand,
            "inventory" => $inventory

        ]);
    }


    /**
     ***************************************************
     ************ BUSCA AS CORES EM RELAÇÂO AO TAMANHO
     ***************************************************/

    /**
     * @return Message
     */
    public function colors(?array $data): void
    {
        $productId = filter_var($data["productId"], FILTER_VALIDATE_INT);
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $inventory = (new Inventory())->find("product_id = :di AND size = :s", "di={$productId}&s={$data["selectedSize"]}");

        echo $this->view->render("colors", [
            "colors" => $inventory->fetch("true")
        ]);
    }


    //AUMENTA A QUANTIDADE DE PRODUTO NA PÁGINA PRODUTO
    public function plus(?array $data): void
    {
        $productId = filter_var($data["productId"], FILTER_VALIDATE_INT);
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $json = null;
        $stockProduct = (new Inventory())->find("product_id = :di  AND color = :c AND size = :s",
            "di={$productId}&c={$data["color"]}&s={$data["size"]}", "amount")->fetch();


        if ($stockProduct) {
            if ($data["amount"] > $stockProduct->amount) {
                $json["nostock"] = true;
            }
            $json["amount"] = $data["amount"];

        }
        echo json_encode($json);
    }


    //INSERE O PRODUTO NA SESSION
    public function bag(?array $data): void
    {
        $session = $this->session($data);
        $json["success"] = true;
        echo json_encode($json);
    }

    //GERA A SESSION
    public function session(?array $data): ?array
    {
        //VERIFICAR O ESTOQUE ANTES DE FINALIZAR
        return $_SESSION['cart'][$data['productId']] = $data;
    }


    /**
     ***************************************************
     ************ CARRINHO DE COMPRAS
     ***************************************************/
    public function cart(?array $data): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("cart", [
            "head" => $head,
            "enterprise" => $this->enterprise()
        ]);
    }

    /**
     ***************************************************
     ************ REMOVE ITENS DO CARRINHO DE COMPRAS
     ***************************************************/
    public function remove(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $amount = null;
        $session = $_SESSION["cart"][$data["productId"]];

        if (isset($session, $data["productId"])) {
            unset($_SESSION["cart"][$data["productId"]]);
            $json["clear"] = true;
            $json["id"] = $data["productId"];
            $json["calculation"] = $this->calculeTotal($_SESSION["cart"]) ?? 0;
            echo json_encode($json);

        }
    }


    public function calculeTotal($session)
    {
        $total = null;
        foreach ($session as $p) :
            $total += ($p['price'] * $p["amount"]);
        endforeach;
        return $total;
    }

    /**
     ***************************************************
     ************ CALCULA FRETE CORREIOS
     ***************************************************/
    public function zipcode(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $session = $_SESSION["cart"];
        $correios = new Client;
        $correios->freight()
            ->origin($_SESSION["enterprise"]->zip_code)
            ->destination($data["zipcode"])
            ->services(Service::SEDEX, Service::PAC);

        foreach ($session as $p) {
            $product = (new Products())->findById($p['productId'], "id, weight, depth, width, length");
            $correios->freight()->item($product->width, $product->depth, $product->length, $product->weight, $p['amount']);  // largura, altura, comprimento, peso e quantidade
        }
        $correios->freight()->calculate();

        //GERA A SESSION DO FRETE
        $frete = $_SESSION["zipcode"] = $correios->freight()->calculate();

        $json["calcule"] = $correios->freight()->calculate();
        echo json_encode($json);
    }


    /**
     ***************************************************
     ************ CHECKOUT
     ***************************************************/

    public function checkout(): void
    {
        $session = $_SESSION["cart"] ?? null;
        $cartTotal = $this->sessionCartTotal($session);

        $installment = new Installments();
        $installments = [];

        for ($i = 1; $i <= 12; $i++) {
            $value = $installment->generate($cartTotal, $i);
            $installments[] = [
                'installment' => $i,
                'value' => (float)$value
            ];
        }


        $head = $this->seo->render(
            "Finalize seu pedido " . CONF_SITE_NAME . " - " . CONF_SITE_DESC,
            CONF_SITE_DESC,
            url("/cliente/checkout"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("checkout", [
            "head" => $head,
            "session" => $session,
            "enterprise" => $this->enterprise(),
            'installments' => $installments,
            "subTotal" => $cartTotal
        ]);
    }


    public function priceFrete(?array $data): void
    {

        if (isset($data["type"], $_SESSION["zipcode"])) {
            foreach ($_SESSION["zipcode"] as $p) {
                if ($p["name"] == $data["type"]) {
                    $json["type"] = $p["name"];
                    $json["price"] = $p["price"];
                    $json["days"] = $p["deadline"];
                    echo json_encode($json);
                }
            }
        }

        if ($data["type"] == 'store') {
            $json["type"] = "Retirar na Loja";
            $json["price"] = 0;
            $json["days"] = 0;
            echo json_encode($json);
        }
    }


    /************************************************************************
     ************************************************************************
     ************ RETORNA OS DADOS DO CLIENTE EM RELAÇÃO AO DOCUMENTO DE CPF
     ************************************************************************/

    public function document(?array $data): void
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
        $client = (new Clients())->find("document = :doc", "doc={$data["document"]}")->fetch();

        if ($client) {
            $json['client'][] = [
                "address" => $client->address,
                "phone" => $client->phone,
                "email" => $client->email,
                "zipcode" => $client->zipcode,
                "city" => $client->city,
                "state" => $client->state,
                "square" => $client->square,
                "number" => $client->number,
                "complement" => $client->complement,
                "reference" => $client->reference,
                "client" => $client->name,
            ];
        } else {
            $json["clear"] = 'clear';
        }
        echo json_encode($json);
    }


    /************************************************************************
     ************************************************************************
     ************ FINALIZA O PEDIDO
     ************************************************************************/
    public function orders(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
        $data["phone"] = preg_replace('/[^0-9]/', '', $data["phone"]);


        if (empty($data['csrf'])) {
            echo "Requisição inválida";
            die();
        }

        //VALIDA O PEDIDO
        $checkoutValidator = new CheckoutValidator($data, $this->message);
        $errorMessages = $checkoutValidator->getErrorMessages();
        if ($errorMessages) {
            echo $errorMessages;
            die();
        }

        //CRIA OU ATUALIZA O CLIENTE
        $clientRepository = new ClientRepository();
        $client = $clientRepository->save($data);

        //CRIA O PEDIDO
        $orderRepository = new OrdersRepository();
        $order = $orderRepository->create($data, $client->id, $_SESSION['cart'] ?? []);

        //EFETUA A BAIXA NO ESTOQUE
        foreach ($_SESSION["cart"] as $p) {
            $stock = (new Inventory())->find("product_id = :p AND size = :s AND color = :c", "p={$p["productId"]}&s={$p["size"]}&c={$p["color"]}")->fetch();
            $stockDown = $stock->amount - $p["amount"];
            $stock->amount = $stockDown;
            $stock->save();
        }

        //DADOS DA MENSAGEM
        $json["name"] =  $data["name"] ;
        $json["document"] =  $data["document"] ;
        $json["numberOrder"] =  $order->id;
        $json["method"] = paymentMethod($data["payment_method"]);


        $json["phone"] = "65996622520";




        $json["completed"] = true;

        //$this->sessioClear();
        echo json_encode($json);
    }


    /************************************************************************
     ************************************************************************
     ************ LIMPA AS SESSIONS CRIADAS
     ************************************************************************/
    public function sessioClear(): void
    {
        unset($_SESSION["cart"]);
        unset($_SESSION["zipcode"]);
    }


    public function sessionCartTotal(array $sessionCart)
    {
        $total = null;
        if (!empty($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $p) {
                $total += ($p["amount"] * $p["price"]);
            }
            return $total;
        }
    }
}