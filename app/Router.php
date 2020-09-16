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
    protected array $routes = [];

    /**
     * @var string
     */
    protected string $path = "/";

    /**
     * @return array
     */
    public function getRoutes()
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
     * Add new route
     * @param string $uri
     * @param $handler
     * @param string[] $methods
     */
    public function addRoute(string $uri, $handler, $methods = ['GET'])
    {
        $this->routes[$uri] = new Route($methods, $handler);
    }


    /**
     * @return mixed
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function getResponse()
    {
        // Check if requested route exists
        if (!isset($this->routes[$this->path])) {
            header(":", true, 404);
            throw new RouteNotFoundException();
        }

        $route = $this->routes[$this->path];

        // Check for allowed request verb
        if (!in_array($_SERVER['REQUEST_METHOD'], $route->getMethods())) {
            header(":", true, 405);
            throw new MethodNotAllowedException();
        }

        return $route->getHandler();
    }

}