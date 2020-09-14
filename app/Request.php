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
     * Get request method
     * @return mixed
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

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
     * @param array $inputs
     * @return array
     */
    public function only(array $inputs)
    {
        $body = [];
        foreach ($inputs as $key) {
            $body[$key] = $this->all()[$key];
        }

        return $body;
    }

    /**
     * Fetch all body property except $inputs array
     * @param array $inputs
     * @return array
     */
    public function except(array $inputs)
    {
        foreach ($inputs as $key) {
            unset($this->all()[$key]);
        }

        return $this->all();
    }
}