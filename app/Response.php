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
     * Get response body which is setted by setBody
     * @return mixed
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set response body
     * @param mixed $body
     * @return Response
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }


    /**
     * Get response body as JSON format
     * @param $body
     * @return Response
     */
    public function withJSON($body)
    {
        header('Content-Type: application/json');

        $this->body = json_encode($body);
        return $this;
    }

    /**
     * Set Status code to Response
     * @param StatusCodes|int $statusCode
     * @return Response
     */
    public function withStatus($statusCode)
    {
        $this->httpStatus = $statusCode;
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

    /**
     * Show twig template
     * @param $template
     * @param array $payload
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function view($template, array $payload = [])
    {
        return View::render($template, $payload);
    }
}

