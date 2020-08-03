<?php
namespace MiniPHP;


/**
 * Class App
 * @package MiniPHP
 */
class App
{
    protected $container;
    public $router;

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
        $this->container->router->addRoute($uri, $handler);
    }

    public function run(){
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        $response = $router->getResponse();
        $this->execute($response);
    }

    public function execute($callable)
    {
        return $callable();
    }

}