<?php


namespace Source\App\Admin;


use Source\Models\Brands\Brands;
use Source\Models\Category;
use Source\Models\Gallery\Gallery;
use Source\Models\Inventory\Inventory;
use Source\Models\ProductGallery\ProductGallery;
use Source\Models\Products\Products;
use Source\Models\ProductsCategories\ProductsCategories;
use Source\Models\Stocks\Stocks;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

class ProductController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(?array $data): void
    {

        $products = (new Products())->findCustom("SELECT
	products.name, 
	products.image, 
	products.price, 
	products_categories.category, 
	products.category_id,
	products.status,
	products.id,
	products.code
FROM
	products
	INNER JOIN
	products_categories
	ON 
		products.category_id = products_categories.id");


        $pager = new Pager(url("/admin/product/home/"));
        $pager->pager($products->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Produtos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/product/home", [
            "app" => "product/home",
            "head" => $head,
            "products" => $products->order("status ASC, category_id ASC, name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }


    public function show(): void
    {
        //CATEGORIAS
        $categories = (new ProductsCategories())->find();
        //FABRICANTES
        $brands = (new Brands())->find();


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Novo produto",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/product/products", [
            "app" => "",
            "head" => $head,
            "categories" => $categories->order("category ASC")->fetch(true),
            "brands" => $brands->order("name ASC")->fetch(true),
        ]);
    }

    //CRIA O PRODUTO
    public function create(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Products();
            $create->name = $data["name"];
            $create->code = $data["code"];
            $create->url = str_slug($data["name"]);
            $create->price = saveMoney($data['price']);
            $create->category_id = $data['category_id'];
            $create->brand_id = $data['brand_id'];
            $create->code = $data['code'];
            $create->status = $data['status'];
            $create->length = $data['length'];
            $create->width = $data['width'];
            $create->weight = saveMoney($data['weight']);
            $create->depth = $data['depth'];
            $create->description = $data['description'];
            $create->user_id = user()->id;
            $create->created = date("Y-m-d H:i:s");


            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $create->name);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $create->image = $image;
            }

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            //GERA O CODE CASO NÃO SEJA INFORMADO
            if ($create->save() and empty($data['code'])) {
                $code = (new Products())->findById($create->id);
                $code->code = $create->id;
                $code->save();
            }
            $this->message->success("Produto cadastrado com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/product/edit/{$create->id}")]);
            return;
        }
    }


    public function edit(?array $data): void
    {
        $productId = filter_var($data["id"], FILTER_VALIDATE_INT);
        //CATEGORIAS
        $categories = (new ProductsCategories())->find();
        //FABRICANTES
        $brands = (new Brands())->find();
        $product = (new Products())->findById($productId);
        $inventory = (new Inventory())->find("product_id = :p", "p={$productId}");
        $gallery = (new Gallery())->find("product_id = :p", "p={$productId}");

        if (empty($product)) {
            $this->message->warning("Opps. Você tentou acessar um produto que não existe.")->flash();
            echo json_encode(["redirect" => url("/admin/product/home")]);
            return;
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Novo produto",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/product/edit", [
            "app" => "",
            "head" => $head,
            "categories" => $categories->order("category ASC")->fetch(true),
            "brands" => $brands->order("name ASC")->fetch(true),
            "product" => $product,
            "inventory" => $inventory->order("id DESC")->fetch(true),
            "gallery" => $gallery->order("id DESC")->fetch(true)
        ]);
    }

    //ATUALIZA PRODUTO
    public function update(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $update = (new Products())->findById($data["id"]);

            if (!$update) {
                $this->message->error("Você tentou editar um produto que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/product/home")]);
                return;
            }

            $update->name = $data["name"];
            $update->code = $data["code"];
            $update->url = str_slug($data["name"]);
            $update->price = saveMoney($data['price']);
            $update->category_id = $data['category_id'];
            $update->brand_id = $data['brand_id'];
            $update->code = $data['code'];
            $update->status = $data['status'];
            $update->length = $data['length'];
            $update->width = $data['width'];
            $update->weight = saveMoney($data['weight']);
            $update->depth = $data['depth'];
            $update->description = $data['description'];
            $update->user_id = user()->id;
            $update->lastupdate = date("Y-m-d H:i:s");

            //upload cover
            if (!empty($_FILES["image"])) {
                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, $update->name);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $update->image = $image;
            }

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            //ATUALIZA O ESTOQUE
            $json["message"] = $this->message->success("Produto atualizado com sucesso...")->render();
            echo json_encode($json);
            return;

        }
    }

    public function delete(?array $data): void
    {

        $productId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $delete = (new Products())->findById($productId);
        $deleteGallery = (new Gallery())->find("product_id = :di", "di={$productId}")->fetch(true);
        $inventory = (new Inventory())->find("product_id = :di", "di={$productId}")->fetch(true);

        if ($delete) {

            if ($delete->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$delete->image}");
                (new Thumb())->flush($delete->image);
            }

            //DELETE DA GALERIA
            if ($deleteGallery) {
                foreach ($deleteGallery as $g) {
                    if ($g->uri && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$g->uri}")) {
                        unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$g->uri}");
                        (new Thumb())->flush($g->uri);
                    }
                    $g->destroy();
                }
            }

            //DELETA INVENTATIO

            if($inventory){
                foreach ($inventory as $p){
                    $p->destroy();
                }
            }

            //DELETA PRODUTO
            $delete->destroy();
            $this->message->success("Produto removido com sucesso.")->flash();
            echo json_encode(["redirect" => url("/admin/product/home")]);
        }
    }
}
