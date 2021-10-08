<?php


namespace Source\App\Admin;


use Source\Models\Category;
use Source\Models\Products\Products;
use Source\Models\ProductsCategories\ProductsCategories;
use Source\Support\Pager;

class categoryController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(?array $data): void
    {
        $categories = (new ProductsCategories())->find();
        $pager = new Pager(url("/admin/category/home/"));
        $pager->pager($categories->count(), 30, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Categoria",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/category/home", [
            "app" => "",
            "head" => $head,
            "categories" => $categories->order("category ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }


    //MANAGER
    public function categories(?array $data): void
    {

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new ProductsCategories();
            $create->category = $data["category"];
            $create->slug = str_slug($data["category"]);
            $create->created = date("Y-m-d H:i:s");
            $create->user_id = user()->id;


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Categoria cadastrada com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/category/categories/{$create->id}")]);

            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new ProductsCategories())->findById($data["id"]);


            if (!$delete) {
                $this->message->error("Você tentou remover uma categoria que não existe ou já foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/category/home")]);
                return;
            }
            if (!$delete->destroy()) {
                $json["message"] = $delete->message()->render();
                echo json_encode($json);
                return;
            }

            $delete->destroy();
            $this->message->success("Categoria excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/category/home")]);
            return;
        }


        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $update = (new ProductsCategories())->findById($data["id"]);

            if (!$update) {
                $this->message->error("Você tentou editar uma categoria que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/category/home")]);
                return;
            }

            $update->category = $data["category"];
            $update->slug = str_slug($data["category"]);
            $update->lastupdate = date("Y-m-d H:i:s");
            $update->user_id = user()->id;

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Categoria atualizada com sucesso...")->render();
            echo json_encode($json);

            return;
        }

        $update = null;
        if (!empty($data["id"])) {
            $channelId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new ProductsCategories())->findById($channelId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Categoria",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/category/categories", [
            "app" => "",
            "head" => $head,
            "category" => $update
        ]);
    }

    //CRIA A CATEGORIA NO FORM DO PRODUTO

    public function products(?array $data): void
    {

        $category = new ProductsCategories();
        $category->category = $data["category"];
        $category->slug = str_slug($data["category"]);
        $category->user_id = user()->id;
        $category->created = date("Y-m-d H:i:s");


        if (!$category->save()) {
            $json['message'] = 'error';
        } else {
            $json['name'] = $data["category"];
            $json['value'] = $category->id;
        }
        echo json_encode($json);
    }
}