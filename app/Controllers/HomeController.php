<?php
namespace MiniPHP\Controllers;

use MiniPHP\Response;

class HomeController
{

    protected $db;

    /**
     * HomeController constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function index(Response $response)
    {
        var_dump($response);
    }

    public function me()
    {
        echo "me controller";
    }

    public function hi()
    {
        echo "hi controller";
    }
    public function signup()
    {
        echo "signup controller";
    }
}