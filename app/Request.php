<?php

namespace MiniPHP;

/**
 * Class Request
 * @package MiniPHP
 * @author KingRayhan
 */
class Request
{
    private ?array $jsonBody = null;
    private array $params = [];

    /**
     * Get all body params (form-encoded, query string, and JSON)
     * @return array
     */
    public function all()
    {
        return array_merge($_REQUEST, $this->json());
    }

    /**
     * Get parsed JSON body
     * @return array
     */
    public function json(): array
    {
        if ($this->jsonBody === null) {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (str_contains($contentType, 'application/json')) {
                $raw = file_get_contents('php://input');
                $this->jsonBody = json_decode($raw, true) ?? [];
            } else {
                $this->jsonBody = [];
            }
        }
        return $this->jsonBody;
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
        $data = $this->all();
        foreach ($keys as $key) {
            unset($data[$key]);
        }
        return $data;
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

    /**
     * Validate request data against rules
     * @param array $rules
     * @return Validator
     */
    /**
     * Set path parameters (called by the framework)
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Get a path parameter by name
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function param(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->params;
        }
        return $this->params[$key] ?? $default;
    }

    /**
     * Validate request data against rules
     * @param array $rules
     * @return Validator
     */
    public function validate(array $rules): Validator
    {
        return Validator::make($this->all(), $rules);
    }
}