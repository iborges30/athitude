<?php

namespace Source\Models\Clients;

class ClientRepository
{

    public function save($data)
    {
        $client = (new Clients())->find("document = :doc", "doc={$data["document"]}")->fetch();
        if (!$client) {
            $client = new Clients();
            $client->name = $data["name"];
            $client->document = $data["document"];
            $client->phone = $data["phone"];
            $client->email = $data["email"];
            $client->zipcode = $data["zipcode"];


            $client->address = $data["address"];
            $client->state = $data["state"];
            $client->city = $data["city"];

            $client->square = $data["square"];
            $client->number = $data["number"];
            $client->complement = $data["complement"];
            $client->reference = $data["reference"];

            $client->save();


        } else {
            $client->document = $data["document"];
            $client->name = $data["name"];
            $client->phone = $data["phone"];
            $client->email = $data["email"];
            $client->zipcode = $data["zipcode"];

            $client->address = $data["address"];
            $client->state = $data["state"];
            $client->city = $data["city"];

            $client->square = $data["square"];
            $client->number = $data["number"];
            $client->complement = $data["complement"];
            $client->reference = $data["reference"];

            $client->save();
        }
        return $client;
    }
}
