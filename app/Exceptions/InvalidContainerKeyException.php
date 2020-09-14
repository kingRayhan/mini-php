<?php

namespace MiniPHP\Exceptions;

use Exception;

/**
 * Class InvalidContainerKeyException
 * @package MiniPHP\Exceptions
 * @author KingRayhan
 */
class InvalidContainerKeyException extends Exception
{
    protected $message = "Container key not exists";
    protected $code = 404;
}