<?php


namespace Source\Models\Orders\Installments;


use Source\Models\Enterprises\Enterprises;

class Installments
{

    public function generate($price, $installments = 1)
    {
        $m = (new Enterprises())->findById(1);


        if($installments <= $m->interest_free_installments){
            return $price/$installments;
        }

        $price = $price + ($price * ($this->getRate($installments) / 100));
        return $price/$installments;
    }


    private function getRate($installments)
    {
        $installmentRates = [
            1 => 2.50,
            2 => 3.25,
            3 => 3.25,
            4 => 3.5,
            5 => 3.5,
            6 => 3.5,
            7 => 4,
            8 => 4,
            9 => 4,
            10 => 4,
            11 => 4,
            12 => 4,
        ];
        if(!isset($installmentRates[$installments]))
        {
            throw new Exception('O numero limite de parcelamento foi excedido, o máximo permitido são 12 parcelas');
        }
        return $installmentRates[$installments];
    }
}