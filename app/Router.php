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
    protected string $path = "/";
    protected array $params = [];

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
        $this->routes[] = new Route($methods, $handler, $uri);
    }

    /**
     * @return array [handler, params]
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function getResponse()
    {
        $methodNotAllowed = false;

        foreach ($this->routes as $route) {
            $params = $this->matchRoute($route->getUri(), $this->path);

            if ($params === false) {
                continue;
            }

            if (!in_array($_SERVER['REQUEST_METHOD'], $route->getMethods())) {
                $methodNotAllowed = true;
                continue;
            }

            $this->params = $params;
            return $route->getHandler();
        }

        if ($methodNotAllowed) {
            header(":", true, 405);
            throw new MethodNotAllowedException();
        }

        header(":", true, 404);
        throw new RouteNotFoundException();
    }

    /**
     * @return array Extracted path parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Match a route pattern against a path, extracting {param} values.
     * Returns associative array of params on match, false otherwise.
     */
    private function matchRoute(string $pattern, string $path): array|false
    {
        // Fast path: exact match with no params
        if ($pattern === $path && !str_contains($pattern, '{')) {
            return [];
        }

        $patternSegments = explode('/', trim($pattern, '/'));
        $pathSegments = explode('/', trim($path, '/'));

        if (count($patternSegments) !== count($pathSegments)) {
            return false;
        }

        $params = [];

        foreach ($patternSegments as $i => $segment) {
            if (preg_match('/^\{(\w+)\}$/', $segment, $matches)) {
                $params[$matches[1]] = $pathSegments[$i];
            } elseif ($segment !== $pathSegments[$i]) {
                return false;
            }
        }

        return $params;
    }
}
