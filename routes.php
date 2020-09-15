<?php

use MiniPHP\Controllers\HomeController;

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

$app->get('/', [HomeController::class, 'index']);
