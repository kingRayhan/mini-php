<?php
require_once __DIR__ . '/vendor/autoload.php';

use MiniPHP\App;
use MiniPHP\Controllers\ParcelController;
use MiniPHP\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die("Unable to find .env file");
}

$app = new App();
$container = $app->getContainer();

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();


$app->get('/', [ParcelController::class, 'index']);

$app->get('/test', function (Response $response) {

    $posts = [
        ['id' => '1', 'title' => 'title 1'],
        ['id' => '2', 'title' => 'title 2'],
        ['id' => '3', 'title' => 'title 3'],
    ];

    return $response->toJson($posts);
});

$app->run();


