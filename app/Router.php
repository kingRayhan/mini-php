<?php

namespace MiniPHP;

use MiniPHP\Exceptions\MethodNotAllowedException;
use MiniPHP\Exceptions\RouteNotFoundException;

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
     * @throws RouteNotFoundException
     */
    public function getResponse()
    {
        $routerPath = $this->path;
        $methods = $this->methods[$routerPath];
        $request_verb = $_SERVER['REQUEST_METHOD'];

        // Check if requested route exists
        if(!isset($this->routes[$routerPath]))
        {
            header(':', true, 404);
            throw new RouteNotFoundException();
        }

        // Check for allowed request verb
        if(!in_array($request_verb, $methods))
        {
            header(':', true, 405);
            throw new MethodNotAllowedException();
        }

        return $this->routes[$this->path];
    }

}