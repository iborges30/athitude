<?php


namespace Source\App\Admin;


use Source\Models\Brands\Brands;
use Source\Models\Category;
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
            echo json_encode(["redirect" => url("/admin/product/products")]);
            return;
        }
    }
}
