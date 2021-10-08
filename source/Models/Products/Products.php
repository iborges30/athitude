<?php


namespace Source\Models\Products;


use Source\Core\Model;

class Products extends Model
{
    public function __construct()
    {
        parent::__construct("products", ["id"], ["name", "price", "description", "status", "weight", "depth", "width", "length"]);
    }


    public function save(): bool
    {
        if (!$this->checkCodeProducts() or
            !parent::save()) {
            return false;
        }
        $this->checkProductUrl();
        return true;
    }


    /*
     * EVITA DUPLICAÇÃO DE PRODUTO
     */
    protected function checkCodeProducts(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("code = :c", "c={$this->code}")->count();
        } else {
            $check = $this->find("code = :c AND id != :di ", "c={$this->code}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! esta Código já foi usado em outro produto.")->render();
            return false;
        }

        return true;
    }


    /*
     * CASO A URL DO PRODUTO BATA ELE ADICIONA O ID + 1 A URL
     */
    public function checkProductUrl()
    {
        $checkUrl = (new Products())->find("url = :url AND id != :id", "url={$this->url}&id={$this->id}");
        if ($checkUrl->count()) {
            $this->url = "{$this->url}-{$this->lastId()}";
        }
        return true;
    }
}