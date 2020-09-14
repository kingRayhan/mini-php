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

    /**
     * Route constructor.
     * @param array $methods
     * @param $handler
     */
    public function __construct(array $methods, $handler)
    {
        $this->methods = $methods;
        $this->handler = $handler;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @return Closure
     */
    public function getHandler()
    {
        return $this->handler;
    }
    
}