<?php

/**
 * -------------------------------------------------------
 *      MiniPHP Routes
 * -------------------------------------------------------
 */

use MiniPHP\Controllers\ParcelController;

$app->get('/', [ParcelController::class, 'index']);