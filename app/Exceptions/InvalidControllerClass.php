<?php

namespace MiniPHP\Exceptions;

use Exception;

/**
 * Class InvalidControllerClass
 * @package MiniPHP\Exceptions
 * @author KingRayhan
 */
class InvalidControllerClass extends Exception
{
    /**
     * @var string
     */
    protected $message = "Invalid controller class reference";
}