<?php


namespace MiniPHP\Exceptions;


class RouteNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Route not found", 404);
    }
}