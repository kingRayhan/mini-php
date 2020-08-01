<?php

require_once  __DIR__ . '/vendor/autoload.php';


$app = new \MiniPHP\App();
$container = $app->getContainer();


$container['config'] = function(){
    return [
        'name' => 'Rayhan'
    ];
};



// var_dump($container->has('config'));