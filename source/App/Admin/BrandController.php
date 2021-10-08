<?php


namespace Source\App\Admin;


use Source\Models\Brands\Brands;
use Source\Support\Pager;

class BrandController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function home(?array $data): void
    {
        $brands = (new Brands())->find();
        $pager = new Pager(url("/admin/brand/home/"));
        $pager->pager($brands->count(), 30, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Nova Fabricante",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/brand/home", [
            "app" => "",
            "head" => $head,
            "brands"=>$brands->order("name ASC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);

    }

    public function brands(?array $data): void
    {

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $create = new Brands();
            $create->name = $data["name"];
            $create->slug = str_slug($data["name"]);
            $create->created = date("Y-m-d H:i:s");
            $create->user_id = user()->id;


            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Fabricante cadastrada com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/brand/brands/{$create->id}")]);

            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $delete = (new Brands())->findById($data["id"]);

           if (!$delete) {
                $this->message->error("Você tentou remover uma categoria que não existe ou já foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/brand/home")]);
                return;
            }


            if (!$delete->destroy()) {
                $json["message"] = $delete->message()->render();
                echo json_encode($json);
                return;
            }

            $delete->destroy();
            $this->message->success("Fabricante excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/brand/home")]);
            return;
        }


        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $update = (new Brands())->findById($data["id"]);

            if (!$update) {
                $this->message->error("Você tentou editar uma categoria que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/brand/home")]);
                return;
            }

            $update->name = $data["name"];
            $update->slug = str_slug($data["name"]);
            $update->lastupdate = date("Y-m-d H:i:s");
            $update->user_id = user()->id;

            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Fabricante atualizada com sucesso...")->render();
            echo json_encode($json);

            return;
        }

        $update = null;
        if (!empty($data["id"])) {
            $brandId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new Brands())->findById($brandId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Novo Fabricante",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/brand/brands", [
            "app" => "",
            "head" => $head,
            "brand" => $update
        ]);
    }

    //CRIA A CATEGORIA NO FORM DO PRODUTO

    public function products(?array $data): void
    {
        $brand = new Brands();
        $brand->name = $data["brand"];
        $brand->slug = str_slug($data["brand"]);
        $brand->user_id = user()->id;
        $brand->created = date("Y-m-d H:i:s");


        if (!$brand->save()) {
            $json['message'] = 'error';
        } else {
            $json['name'] = $data["brand"];
            $json['value'] = $brand->id;
        }
        echo json_encode($json);
    }
}