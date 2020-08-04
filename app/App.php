<?php
namespace MiniPHP;


use MiniPHP\Exceptions\MethodNotAllowedException;

/**
 * Class App
 * @package MiniPHP
 */
class App
{
    protected $container;

    /**
     * App constructor.
     */
    public function __construct(){
        $this->container = new Container([
            'router' => function () {
                return new Router;
            },
        ]);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['GET']);
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['POST']);
    }

    public function run(){
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        try {
            $response = $router->getResponse();
            $this->execute($response);
        }catch (MethodNotAllowedException $e){
            die($e->getCode() . " ". $e->getMessage());
        }
    }

    public function execute($callable)
    {
        return $callable();
    }

}