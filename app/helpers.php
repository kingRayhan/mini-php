<?php

use MiniPHP\Request;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Response object helper
 * @return \MiniPHP\Response
 */
function response()
{
    return new \MiniPHP\Response();
}

/**
 * @param $data
 * @return false|string
 */
function toJSON($data)
{
    return response()->withJSON($data);
}

/**
 * @return Request
 */
function request()
{
    return new Request();
}

/**
 * @return \MiniPHP\Flash
 */
function flash()
{
    return new \MiniPHP\Flash();
}