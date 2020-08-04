<?php
require_once __DIR__ . '/vendor/autoload.php';

use MiniPHP\App;
use MiniPHP\Controllers\HomeController;
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

$container['config'] = function () {
    return [
        'db_driver' => $_ENV['DB_DRIVER'],
        'db_host' => $_ENV['DB_HOST'],
        'db_name' => $_ENV['DB_NAME'],
        'db_user' => $_ENV['DB_USER'],
        'db_pass' => $_ENV['DB_PASS']
    ];
};

$container['db'] = function ($c) {
    try {
        return new PDO(
            $c->config['db_driver'] . ':host=' . $c->config['db_host'] . ';dbname=' . $c->config['db_name'],
            $c->config['db_user'],
            $c->config['db_pass']
        );
    } catch (PDOException $e) {
        die("<mark>PDOException:</mark> " . $e->getMessage());
    }
};


$app->get('/', [HomeController::class, 'index']);
$app->get('/me', [HomeController::class, 'me']);
$app->post('/signup', [HomeController::class, 'signup']);
$app->map('/hi', [HomeController::class, 'hi'] , ['GET', 'PATCH']);

$app->run();


