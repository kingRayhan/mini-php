<?php

namespace MiniPHP;

/**
 * Class Router
 * @package MiniPHP
 */
class Router
{
    protected $routes = [];
    protected $path = "/";

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path = '/')
    {
        $this->path = $path;
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function addRoute($uri, $handler)
    {
        $this->routes[$uri] = $handler;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->routes[$this->path];
    }

}