<?php

require_once __DIR__ . '/../vendor/autoload.php';

function toJSON($data)
{
    return json_encode($data);
}

/**
 * Response object helper
 * @return \MiniPHP\Response
 */
function response()
{
    return new \MiniPHP\Response();
}

function request()
{
    return new \MiniPHP\Request();
}