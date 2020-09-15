<?php

namespace MiniPHP;

use Slim\Flash\Messages;

/**
 * Class Flash
 * @package MiniPHP
 */
class Flash
{
    /**
     * @var Messages
     */
    private $flash;

    /**
     * Flash constructor.
     */
    public function __construct()
    {
        $this->flash = new Messages();
    }

    /**
     * Add flash Message
     * @param $key
     * @param $message
     * @return void
     */
    public function add($key, $message)
    {
        $this->flash->addMessage($key, $message);
    }

    /**
     * Get flash message for a key
     * @param $key
     * @return mixed|string|void|null
     */
    public function get($key)
    {
        if (!$this->has($key)) return;
        return $this->flash->getMessage($key)[0];
    }

    /**
     * Check if flash message exists for a key
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return $this->flash->hasMessage($key);
    }

    /**
     * Clear all flashes
     * @return void
     */
    public function clear()
    {
        $this->flash->clearMessages();
    }
}