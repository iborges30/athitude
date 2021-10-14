<?php


namespace Source\Models\Inventory;


use Source\Core\Model;

class Inventory extends Model
{
    public function __construct()
    {
        parent::__construct("inventory", ["id"], ["amount", "color", "size"]);
    }

}