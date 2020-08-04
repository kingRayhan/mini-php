<?php

namespace MiniPHP;


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
    public function __construct()
    {
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
     * Get route handler
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['GET']);
    }

    /**
     * Post route handler
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['POST']);
    }


    /**
     * Multiple route verb handler
     * @param $uri
     * @param $handler
     * @param string[] $methods
     */
    public function map($uri, $handler, $methods = ['GET'])
    {
        $this->container->router->addRoute($uri, $handler, $methods);
    }


    /**
     *  Run the application
     */
    public function run()
    {
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        $response = $router->getResponse();
        $this->execute($response);
    }


    /**
     * @param $callable
     * @return mixed
     */
    public function execute($callable)
    {

        if (is_array($callable)) { // when the call able is a controller
            // check if its already instantiated
            if (!is_object($callable[0])) {
                $callable[0] = new $callable[0];
            }

            return call_user_func($callable);
        }

        return $callable();
    }

}