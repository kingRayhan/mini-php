<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

use MiniPHP\App;
use MiniPHP\Orm;
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

/**
 * Load orm to App Container
 */
$orm = new Orm();
$container['orm'] = $orm->boot();


$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

require __DIR__ . '/routes.php';

$app->run();


