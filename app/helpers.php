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

/**
 * The StartsWith() function is used to test whether a string begins with the given string or not.
 * This function is case insensitive and it returns boolean value.
 * This function can be used with Filter function to search the data.
 * @param $string
 * @param $startString
 * @return bool
 * @src https://www.geeksforgeeks.org/php-startswith-and-endswith-functions/
 */
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return substr($string, 0, $len) === $startString;
}

/**
 * The endsWith() function is used to test whether a string ends with the given string or not.
 * This function is case insensitive and it returns boolean value.
 * The endsWith() function can be used with the Filter function to search the data.
 * @param $string
 * @param $endString
 * @return bool
 * @src https://www.geeksforgeeks.org/php-startswith-and-endswith-functions/
 */
function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return substr($string, -$len) === $endString;
}