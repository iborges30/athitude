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
}
