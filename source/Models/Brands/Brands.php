<?php


namespace Source\Models\Brands;


use Source\Core\Model;
use Source\Models\Products\Products;

class Brands extends Model
{
    public function __construct()
    {
        parent::__construct("brands", ["id"], ["name"]);
    }


    public function save(): bool
    {
        if (!$this->checkSlug() or
            !parent::save()) {
            return false;
        }
        return true;
    }

    //POLI DO METODO DESTROY
    public function destroy(): bool
    {
        if (!$this->chechkDelete() or !parent::destroy()) {
            return false;
        }
        return true;
    }


    //VERIFICA PRODUTO LIGADO AO FABRICANTE
    protected function chechkDelete(): bool
    {
        $check = (new Products())->find("brand_id = :b", "b={$this->id}")->count();
        if ($check) {
            $this->message->warning("Ooops! Você não pode deletar um fabricante que esteja sendo usadado em um produto.")->render();
            return false;
        } else {
            return true;
        }
    }

    //DUPLICAÇÃO DE NOME
    protected function checkSlug(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("slug = :c", "c={$this->slug}")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di ", "c={$this->slug}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! este Fabricante já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }
}