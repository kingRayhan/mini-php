<?php

namespace MiniPHP;

use stdClass as RouterParamsObject;

/**
 * Class RouteParser
 * @package MiniPHP
 */
class RouteParser
{
    /**
     * @var RouterParamsObject
     */
    private $params = null;

    /**
     * @var string[]
     */
    private $keys = [];

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $uri;

    /**
     * RouteParser constructor.
     * @param $pattern
     * @param $uri
     */
    public function __construct($pattern, $uri)
    {
        $this->pattern = $pattern;
        $this->uri = $uri;
        $this->params = new RouterParamsObject();
    }

    /**
     * Extract route parameter keys to $keys
     * @return void
     */
    private function extractRouteParamKeys()
    {
        foreach (explode('/', $this->pattern) as $index => $part) {
            $isParam = startsWith($part, '{') && endsWith($part, '}');
            if ($isParam) {
                $this->keys[$index] = substr($part, 1, -1);
            }
        }
    }

    /**
     * set router parameter values to params object
     */
    private function setRouteParamValues()
    {
        foreach ($this->keys as $index => $param) {
            $this->params->{$param} = explode('/', $this->uri)[$index];
        }
    }

    /**
     * Get router params object
     * @return RouterParamsObject
     */
    public function getParams()
    {
        $this->extractRouteParamKeys();
        $this->setRouteParamValues();
        return $this->params;
    }
}