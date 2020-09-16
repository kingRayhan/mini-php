<?php

use MiniPHP\Request;
use MiniPHP\Response;
use MiniPHP\View;

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

//$app->get('/', [HomeController::class, 'index']);

$app->get('/', function (Request $request, Response $response) {

    $cats = [
        ["id" => "1", "name" => 'eni'],
        ["id" => "2", "name" => 'mini'],
        ["id" => "3", "name" => 'bini'],
    ]; // There are my three pet cats 😘

    return View::render('welcome', [
        'cats' => $cats,
        'name' => 'Rayhan'
    ]);
});


$app->get('/posts/{id}', function () {
    return "Hello";
});