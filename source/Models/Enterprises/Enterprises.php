<?php


namespace Source\Models\Enterprises;


use Source\Core\Model;

class Enterprises extends Model
{
    public function __construct()
    {
        parent::__construct("enterprises", ["id"], ["enterprise", "document", "whatsapp"]);
    }

    public function save(): bool
    {
        if (!$this->checkEnterpriseNameDucplicate() or
            !$this->checkValidateDocument() or
            !parent::save()) {
            return false;
        }
        return true;
    }


    /*
     * EVITA DUPLICAÇÃO DE NOME PARA AS EMPRESAS
     */
    protected function checkEnterpriseNameDucplicate(): bool
    {
        $check = null;

        if (!$this->id) {
            $check = $this->find("slug = :c", "c={$this->slug}")->count();
        } else {
            $check = $this->find("slug = :c AND id != :di ", "c={$this->slug}&di={$this->id}")->count();
        }

        if ($check) {
            $this->message->warning("Ooops! Esse nome já foi usado por outra empresa.")->render();
            return false;
        }

        return true;
    }

    //FAZER A VERIFICAÇÃO DA DUPLICIDADE AQUI
    protected function checkValidateDocument(): bool
    {
        if (!validateCnpj($this->document)) {
            $this->message->warning("Ooops! CNPJ informado não tem um formato válido.")->render();
            return false;
        }

        $checkDuplicateDocument = null;
        if (!$this->id) {
            $checkDuplicateDocument = $this->find("document = :doc", "doc={$this->document}")->count();
        } else {
            $checkDuplicateDocument = $this->find("document = :doc AND id != :di", "doc={$this->document}&di={$this->id}")->count();
        }

        if ($checkDuplicateDocument) {
            $this->message->warning("Ooops! CNPJ informado já foi cadastrado anteriormente.")->render();
            return false;
        }

        return true;
    }
}