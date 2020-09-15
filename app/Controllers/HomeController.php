<?php

namespace MiniPHP\Controllers;

use MiniPHP\Request;
use MiniPHP\Response;

/**
 * Home Controller
 * Class HomeController
 * @package MiniPHP\Controllers
 */
class HomeController
{


    /**
     * GET index
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function index(Request $request, Response $response)
    {
        flash()->add('test', 'this is a test flash');

        return $response->view('welcome');
    }
}