<?php

use MiniPHP\Controllers\HomeController;

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

$app->get('/', [HomeController::class, 'index']);

$app->get('/test', function (\MiniPHP\Request $request, \MiniPHP\Response $response) {
    return $response->withJSON($request->query());
});