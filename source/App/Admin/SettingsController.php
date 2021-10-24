<?php


namespace Source\App\Admin;


use Source\Models\Enterprises\Enterprises;
use Source\Support\Thumb;
use Source\Support\Upload;

class SettingsController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function settings(?array $data): void
    {


        //CREATED
        if (!empty($data["action"]) && $data["action"] == "create") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
            $data["whatsapp"] = preg_replace('/[^0-9]/', '', $data["whatsapp"]);

            $create = new Enterprises();
            $create->enterprise = $data["enterprise"];
            $create->slug = str_slug($data["enterprise"]);
            $create->document = $data["document"];
            $create->whatsapp = $data["whatsapp"];

            $create->zip_code = str_replace("-", "", $data["zip_code"]);
            $create->address = $data["address"];
            $create->number = $data["number"];
            $create->district = $data["district"];
            $create->city = $data["city"];
            $create->complement = $data["complement"];
            $create->state = $data["state"];


            $create->user_id = user()->id;
            $create->created = date("Y-m-d H:i:s");

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Empresa cadastrada com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/settings/settings/{$create->id}")]);
            return;
        }

        //UPDATE
        if (!empty($data["action"]) && $data["action"] == "update") {

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $data["document"] = preg_replace('/[^0-9]/', '', $data["document"]);
            $data["whatsapp"] = preg_replace('/[^0-9]/', '', $data["whatsapp"]);
            $update = (new Enterprises())->findById($data["id"]);

            if (!$update) {
                $this->message->error("Você tentou editar um canal que não existe ou foi removido")->flash();
                echo json_encode(["redirect" => url("/admin/faq/home")]);
                return;
            }

            $update->enterprise = $data["enterprise"];
            $update->slug = str_slug($data["enterprise"]);
            $update->document = $data["document"];
            $update->whatsapp = $data["whatsapp"];

            $update->zip_code = str_replace("-", "", $data["zip_code"]);
            $update->address = $data["address"];
            $update->number = $data["number"];
            $update->district = $data["district"];
            $update->city = $data["city"];
            $update->complement = $data["complement"];
            $update->state = $data["state"];


            if (!$update->save()) {
                $json["message"] = $update->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Empresa atualizado com sucesso...")->render();
            echo json_encode($json);

            return;
        }


        $update = null;
        if (!empty($data["id"])) {
            $enterpriseId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $update = (new Enterprises())->findById($enterpriseId);
        }


        $head = $this->seo->render(
            CONF_SITE_NAME . " | Configurações",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/settings/settings", [
            "app" => "settings/settings",
            "head" => $head,
            "enterprise" => $update

        ]);

    }

    public function about(?array $data): void
    {

        if (!empty($data["action"]) && $data["action"] == "updateAbout") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $enterpriseId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $aboutCreate = (new Enterprises())->findById($enterpriseId);


            if (!$aboutCreate) {
                $this->message->warning("Você tentou atualizar uma empresa que não existe no sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/dash")]);
                return;
            }

            $aboutCreate->category = $data["category"];
            $aboutCreate->information = $data["information"];

            //IMAGEM DE CAPA

            if (!empty($_FILES["image"])) {
                if ($aboutCreate->image && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$aboutCreate->image}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$aboutCreate->image}");
                    (new Thumb())->flush($aboutCreate->image);
                }

                $files = $_FILES["image"];
                $upload = new Upload();
                $image = $upload->image($files, str_slug($aboutCreate->enterprise), 1000);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $aboutCreate->image = $image;
            }

            if (!$aboutCreate->save()) {
                $json["message"] = $aboutCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Dados atualizados com sucesso.")->render();
            echo json_encode($json);
            return;

        }
    }

    public function rate(?array $data): void
    {

        if (!empty($data["action"]) && $data["action"] == "updateRate") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $enterpriseId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $aboutCreate = (new Enterprises())->findById($enterpriseId);


            if (!$aboutCreate) {
                $this->message->warning("Você tentou atualizar uma empresa que não existe no sistema.")->flash();
                echo json_encode(["redirect" => url("/admin/dash")]);
                return;
            }

            $aboutCreate->delivery_rate = saveMoney($data["delivery_rate"]);
            $aboutCreate->minimum_order = saveMoney($data["minimum_order"]);
            $aboutCreate->installment = $data["installment"];
            $aboutCreate->interest_free_installments = $data["interest_free_installments"];


            if (!$aboutCreate->save()) {
                $json["message"] = $aboutCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Dados atualizados com sucesso.")->render();
            echo json_encode($json);
            return;

        }
    }
}