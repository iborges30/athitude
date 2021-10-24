<?php


namespace Source\Models\Clients;


use Source\Core\Model;

class Clients extends Model
{
    public function __construct()
    {
        parent::__construct("clients", ["id"], ["name", "document", "phone", "email", "city", "state", "square", "address"]);
    }


  
}