<?php

namespace MiniPHP;

/**
 * Class Response
 * @package MiniPHP
 * @author KingRayhan
 */
class Response
{

    private $body;
    private int $httpStatus = StatusCodes::HTTP_OK;

    /**
     * @return mixed
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Response
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }


    /**
     * @param $body
     */
    public function withJSON($body)
    {
        return json_encode($this->body);
    }

    /**
     * Bind status code with response
     * @param StatusCodes $status
     * @return Response
     */
    public function withStatus($status)
    {
        $this->httpStatus = $status;
        return $this;
    }

    /**
     * Get response status code
     * @return int|StatusCodes
     */
    public function getStatusCode()
    {
        return $this->httpStatus;
    }
}