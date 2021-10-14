<?php


namespace Source\App\Admin;


use Source\Models\Gallery\Gallery;
use Source\Support\Thumb;
use Source\Support\Upload;

class GalleryController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    * GALERIA
    */
    public function gallery(?array $data): void
    {

        $json["gallery"] = null;
        if (!empty($_FILES["gallery"])) {
            $images = $_FILES["gallery"];

            for ($i = 0; $i < count($images["type"]); $i++) {
                foreach (array_keys($images) as $keys) {
                    $imageFiles[$i][$keys] = $images[$keys][$i];
                }
            }

            foreach ($imageFiles as $file) {
                $upload = new Upload();
                $create = new Gallery();
                $image = $upload->image($file, $data['product']);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $create->product_id = $data["product_id"];
                $create->uri = $image;

                if (!$create->save()) {
                    $json["message"] = $create->message()->render();
                    echo json_encode($json);
                    return;
                }

                $json["gallery"][] = ["uri" => $image, "id" => $create->id];
            }

            echo json_encode($json);
        }
    }


    /*
     * DELETE
     */

    public function delete(?array $data): void
    {
        $galleryId = filter_var($data["id"], FILTER_VALIDATE_INT);
        if ($data["image"] && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$data["image"]}")) {
            unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$data["image"]}");
            (new Thumb())->flush($data["image"]);
        }
        $delete = (new Gallery())->findById($galleryId);
        $delete->destroy();

        $json["image"] = $galleryId;
        echo json_encode($json);
    }
}