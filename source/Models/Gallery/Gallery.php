<?php


namespace Source\Models\Gallery;


use Source\Core\Model;

class Gallery extends Model{

    public function __construct()
    {
        parent::__construct("gallery", ["id"], ["uri"]);
    }

}