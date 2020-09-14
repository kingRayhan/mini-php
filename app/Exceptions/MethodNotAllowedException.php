<?php


namespace MiniPHP\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception
{
    public function __construct()
    {
        parent::__construct("Method not allowed", 405);
    }
}