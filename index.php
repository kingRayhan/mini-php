<?php

// PHP built-in server: serve static files directly, set PATH_INFO for routing
if (php_sapi_name() === 'cli-server') {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
        return false;
    }
    $_SERVER['PATH_INFO'] = $uri;
}

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

$routesFile = file_exists(__DIR__ . '/example/routes.php')
    ? __DIR__ . '/example/routes.php'
    : __DIR__ . '/routes.php';
require $routesFile;

$app->run();


