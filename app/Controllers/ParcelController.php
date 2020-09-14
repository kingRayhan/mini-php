<?php


namespace MiniPHP\Controllers;

use MiniPHP\Response;

class ParcelController
{

    public function index(Response $response)
    {
        $posts = [
            ['id' => '1', 'title' => 'title 1'],
            ['id' => '2', 'title' => 'title 2'],
            ['id' => '3', 'title' => 'title 3'],
        ];
        return $response->setBody($posts);
    }

    public function store(Response $response)
    {

    }
}
