<?php

namespace MiniPHP;

use Closure;

/**
 * Class Route
 * @package MiniPHP
 * @author KingRayhan
 */
class Route
{
    private array $methods;
    private $handler;
    private string $uri;

    /**
     * Route constructor.
     * @param array $methods
     * @param $handler
     * @param string $uri
     */
    public function __construct(array $methods, $handler, string $uri = '')
    {
        $this->methods = $methods;
        $this->handler = $handler;
        $this->uri = $uri;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @return Closure|array
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
