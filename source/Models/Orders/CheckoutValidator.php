<?php

namespace Source\Models\Orders;

class CheckoutValidator
{
    protected $data = [];
    protected $message;
    public function __construct($data, $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    public function getErrorMessages()
    {
        $data = $this->data;
        $json = [];
        if (!csrf_verify($data)) {
            $json['message'] = $this->message->info("Erro ao enviar, favor use o formulário")->render();
            return json_encode($json);
        }

        //VERIFICA DOCUMENTO
        if (empty($data['document']) || !validadeDocumentClient($data['document'])) {
            $json['message'] = $this->message->warning("O CPF informado não é válido.")->render();
            return json_encode($json);
        }

        //VERIFICA DOCUMENTO
        if (empty($data['sendOrders'])) {
            $json['message'] = $this->message->warning("Você deve selecionar uma forma de entrega.")->render();
            return json_encode($json);
        }

        //VERIFICA DOCUMENTO
        if (empty($data['payment_method'])) {
            $json['message'] = $this->message->warning("Você deve selecionar uma forma de pagamento.")->render();
            return json_encode($json);
        }

        //WHATSAPP
        if (empty($data['phone'])) {
            $json['message'] = $this->message->warning("Você precisa informar um número de telefone.")->render();
            return json_encode($json);
        }

        //IMPEDE DE SALVAR PEDIDO COM VALOR ZERADO
        if (empty($data['total_orders']) or $data["total_orders"] < 1) {
            $json['message'] = $this->message->warning("Valor indefinido.")->render();
            return json_encode($json);
        }

        //VALIDA O E-maila
        if (empty($data['email']) or !is_email($data["email"])) {
            $json['message'] = $this->message->warning("O E-mail informado não é válido")->render();
            return json_encode($json);
        }
    }
}
