<?php

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

use MiniPHP\Controllers\ParcelController;

$app->get('/', [ParcelController::class, 'index']);
$app->post('/store', [ParcelController::class, 'store']);