<?php

use MiniPHP\Controllers\HomeController;

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

$app->get('/', [HomeController::class, 'index']);

$app->get('/test', function () {
    return flash()->get('test');
});
