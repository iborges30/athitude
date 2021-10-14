<?php


namespace Source\App\Admin;


use Source\Models\Inventory\Inventory;
use Source\Models\Products\Products;

class InventoryController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "createInventory") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $productId = filter_var($data["product_id"], FILTER_VALIDATE_INT);
            $product = (new Products())->findById($productId);
            $create = new Inventory();

            if (!$product) {
                $json["message"] = "Opss. Você está tentando editar um produto que não existe";
                echo json_encode($json);
                return;
            }

            if ($data["amount"] < 1) {
                $json["message"] = "Opps. A quantidade do produto não pode ser inferior a 1.";
                echo json_encode($json);
                return;
            }

            $create->size = $data["size"];
            $create->color = $data["color"];
            $create->product_id = $data["product_id"];
            $create->amount = $data["amount"];
            $create->user_id = user()->id;
            $create->created = date("Y-m-d H:i:s");

            if (!$create->save()) {
                $json["message"] = $create->message()->render();
                echo json_encode($json);
                return;
            }

            $json["size"] = $data["size"];
            $json["color"] = $data["color"];
            $json["amount"] = $data["amount"];
            $json["id"] = $create->id;
            $json["product_id"] = $data["product_id"];
            $json["url"] = url("/admin/inventory/delete");
            echo json_encode($json);
        }
    }

    public function delete(?array $data): void
    {
        $deleteId = filter_var($data["deleteId"], FILTER_VALIDATE_INT);
        $delete = (new Inventory())->findById($deleteId);
        $delete->destroy();
        if ($delete) {
            $json["detele"] = true;
            $json["id"] = $deleteId;
            echo json_encode($json);
        }
    }

   // TRAZ A MODAL DE EDIÇÃO
    public function edit(?array $data): void
    {
        $inventoryId = filter_var($data["inventoryId"], FILTER_VALIDATE_INT);
        $inventory = (new Inventory())->findById($inventoryId);

        echo $this->view->render("widgets/product/modal_inventory", [
            "app" => "modal_inventory",
            "item" => $inventory
        ]);
    }

    //ATUALIZA
    public function update(?array $data):void{
        $inventoryId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $update = (new Inventory())->findById($inventoryId);
        $update->color = $data["color"];
        $update->size = $data["size"];
        $update->amount = $data["amount"];
        $update->user_id = user()->id;
        $update->lastupdate = date("Y-m-d H:i:s");
        $update->save();

        $json["message"] = true;
        echo json_encode($json);
    }
}