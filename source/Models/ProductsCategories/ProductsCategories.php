<?php


namespace Source\Models\ProductsCategories;


use Source\Core\Model;
use Source\Models\Products\Products;

class ProductsCategories extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("products_categories", ["id"], ["category"]);
    }


    public function save(): bool
    {
        if (!$this->checkSlug() or
            !parent::save()) {
            return false;
        }
        return true;
    }


    //FAZER O POLI DO METODO DESTROY

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
        $check = (new Products())->find("category_id = :b", "b={$this->id}")->count();
        if ($check) {
            $this->message->warning("Ooops! Você não pode deletar uma Categoria que esteja sendo usadado em um produto.")->render();
            return false;
        } else {
            return true;
        }
    }


    //EVITA A DUPLICIDADE
    protected function checkSlug(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("slug = :c", "c={$this->slug}")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di ", "c={$this->slug}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! esta categoria já foi cadastrado anteriormente")->render();
            return false;
        }

        return true;
    }


}