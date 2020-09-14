<?php


namespace MiniPHP\Controllers;

use MiniPHP\models\User;
use MiniPHP\Response;

class ParcelController
{

    public function index(Response $response)
    {
        $user = new User();

        $user->create([
            "name" => "my Name",
            "username" => "my username"
        ]);

        echo "created";
    }

    public function store(Response $response)
    {

    }
}
