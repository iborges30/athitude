<?php

namespace Source\Models\Orders;

use Source\Models\Orders\OrdersItems;

class OrdersRepository
{
    public function create($data, $clientId, $cartItems)
    {
        //GRAVAR OS DADOS DO PEDIDO
        $order = new Orders();
        $order->client = $data["name"];
        $order->client_id = $clientId;
        $order->document = $data["document"];
        $order->phone = $data["phone"];
      
        $order->sendOrders = $data['sendOrders'];

        $order->delivery_rate = $data["delivery_rate"];
        $order->deadline = $data["deadline"];
      

        $order->created = date("Y-m-d H:i:s");
        $order->status = "new";
        $order->notification = "open";
        $order->total_orders = $data["total_orders"];
        $order->installments = $data["installments"] ?? 1;
        $order->payment_method = $data["payment_method"] ?? 1;


        $order->save();
        if ($order->save()) {
            //SALVAR OS ITENS DO PEDIDO
            foreach ($cartItems as $items) {
                $createItem = new OrdersItems();
                $createItem->order_id = $order->id;
                $createItem->product_id = $items["productId"];
                $createItem->size = $items["size"];
                $createItem->color = $items["color"];
                $createItem->amount = $items["amount"];
                $createItem->price = $items["price"];
                $createItem->save();
            }
        }

        return $order;
    }
}
