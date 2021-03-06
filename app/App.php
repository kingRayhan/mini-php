<?php

namespace MiniPHP;


use MiniPHP\Exceptions\InvalidControllerClass;
use ReflectionClass;
use ReflectionException;

/**
 * Class App
 * @package MiniPHP
 * @author kingrayhan
 */
class App
{
    protected Container $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->container = new Container([
            'router' => function () {
                return new Router();
            },
            'response' => function () {
                return new Response();
            },
            'request' => function () {
                return new Request();
            }
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
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function get($uri, $handler)
    {
        $this->container->get('router')->addRoute($uri, $handler, ['GET']);
    }


    /**
     * Post route handler
     * @param $uri
     * @param $handler
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function post($uri, $handler)
    {
        $this->container->get('router')->addRoute($uri, $handler, ['POST']);
    }

    /**
     * Put route handler
     * @param $uri
     * @param $handler
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function put($uri, $handler)
    {
        $this->container->get('router')->addRoute($uri, $handler, ['PUT']);
    }

    /**
     * Delete route handler
     * @param $uri
     * @param $handler
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function delete($uri, $handler)
    {
        $this->container->get('router')->addRoute($uri, $handler, ['DELETE']);
    }


    /**
     * Multiple route verb handler
     * @param $uri
     * @param $handler
     * @param string[] $methods
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function map($uri, $handler, $methods = ['GET'])
    {
        $this->container->get('router')->addRoute($uri, $handler, $methods);
    }


    /**
     *  Run the application
     * @throws Exceptions\InvalidContainerKeyException
     */
    public function run()
    {
        $router = $this->container->get('router');
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        $response = $router->getResponse();
        $this->execute($response);
    }


    /**
     * @param $callable
     * @return mixed
     * @throws Exceptions\InvalidContainerKeyException
     * @throws InvalidControllerClass
     */
    public function execute($callable)
    {
        $response = $this->container->get('response');
        $request = $this->container->get('request');

        //-------------  When $callable is a Controller reference
        if (is_array($callable)) {
            $controllerClassReference = $callable[0];
            $method = $callable[1];

            /**
             * Throw InvalidControllerClass then reference class is invalid
             */
            try {
                new ReflectionClass($controllerClassReference);
            } catch (ReflectionException $e) {
                throw new InvalidControllerClass();
            }

            // check if controller class is not instantiated
            if (!is_object($controllerClassReference)) {
                $controllerClassReference = new $controllerClassReference; // instantiate the controller class
            }

            return $this->makeResponse(call_user_func([$controllerClassReference, $method], $request, $response));
        }

        //-------------  When $callable is a Closure
        return $this->makeResponse($callable($request, $response));

    }

    public function makeResponse($response)
    {
        if (!$response instanceof Response) {

            if (!is_string($response)) {
                dd($response);
            }

            echo $response;
            return;
        }
        $httpStatusCode = $response->getStatusCode() ?? 200;
        http_response_code($httpStatusCode);

        echo $response->getBody();
    }
}