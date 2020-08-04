<?php

namespace MiniPHP;

use MiniPHP\Exceptions\MethodNotAllowedException;

/**
 * Class Router
 * @package MiniPHP
 */
class Router
{
    protected $routes = [];
    protected $methods = [];
    /**
     * @var string
     */
    protected $path = "/";

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path = '/')
    {
        $this->path = $path;
    }


    /**
     * @param string $uri
     * @param \Closure $handler
     * @param string[] $methods
     */
    public function addRoute(string $uri, \Closure $handler, $methods = ['GET'])
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    /**
     * @return mixed
     * @throws MethodNotAllowedException
     */
    public function getResponse()
    {
        $routerPath = $this->path;
        $methods = $this->methods[$routerPath];
        $request_verb = $_SERVER['REQUEST_METHOD'];


        if(!in_array($request_verb, $methods))
            throw new MethodNotAllowedException();

        return $this->routes[$this->path];
    }

}