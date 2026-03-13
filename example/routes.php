<?php

use Example\Controllers\PostController;
use Example\Controllers\TodoController;

$app->get('/', function ($request, $response) {
    return $response->view('welcome');
});

// Todo API
$app->group('/api/todos', function ($app) {
    $app->get('', [TodoController::class, 'index']);
    $app->post('', [TodoController::class, 'store']);
    $app->get('/{id}', [TodoController::class, 'show']);
    $app->put('/{id}', [TodoController::class, 'update']);
    $app->delete('/{id}', [TodoController::class, 'destroy']);
});

$app->group('/api/posts', function ($app) {
    $app->get('', [PostController::class, 'index']);
    // $app->get('/{id}', [PostController::class, 'show']);
    // $app->post('', [PostController::class, 'store']);
    // $app->put('/{id}', [PostController::class, 'update']);
    // $app->delete('/{id}', [PostController::class, 'destroy']);
});
