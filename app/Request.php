<?php

namespace MiniPHP;

/**
 * Class Request
 * @package MiniPHP
 * @author KingRayhan
 */
class Request
{

    /**
     * Get all body params
     * @return array
     */
    public function all()
    {
        return $_REQUEST;
    }

    /**
     * Fetch only body params which is matched with $input
     * @param array $keys
     * @return array
     */
    public function only(array $keys)
    {
        $body = [];
        foreach ($keys as $key) {
            $body[$key] = $this->all()[$key] ?? null;
        }

        return $body;
    }

    /**
     * Fetch all body property except $inputs array
     * @param array $keys
     * @return array
     */
    public function except(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->all()[$key]);
        }

        return $this->all();
    }

    /**
     * Get query string value via key
     * @param string|null $key
     * @return array|mixed|string
     */
    public function query(string $key = null)
    {
        if (!isset($key)) {
            return $_GET;
        }
        return $_GET[$key] ?? '';
    }


    /**
     * Get request method
     * @return mixed
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }


    /**
     * Get request uri
     * @return string
     */
    public function path()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get request protocol
     * @return string
     */
    public function protocol()
    {
        return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }


    /**
     * Get request host
     * @return string
     */
    public function host()
    {
        return $_SERVER['HTTP_HOST'];
    }


    /**
     * Get request full url
     * @return string
     */
    public function fullUrl()
    {
        return $this->protocol() . $this->host() . $this->path();
    }
}