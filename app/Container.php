<?php

namespace MiniPHP;

use ArrayAccess;
use Closure;
use MiniPHP\Exceptions\InvalidContainerKeyException;

/**
 * Class Container
 * @package MiniPHP
 * @author KingRayhan
 */
class Container implements ArrayAccess
{
    private array $items = [];
    private array $cache = [];

    /**
     * Container constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $offset => $item) {
            $this[$offset] = $item;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws InvalidContainerKeyException
     */
    public function offsetGet($offset)
    {
        // Throw exception when key is not exits on container
        if (!$this->has($offset)) throw new InvalidContainerKeyException();

        // If the key exists on cache then return from cache
        if (isset($this->cache[$offset])) {
            return $this->cache[$offset];
        }

        if ($this->items[$offset] instanceof Closure) {
            // If request $offset is a instance of Closure
            // then pass the container object to the closure
            $item = $this->items[$offset]($this);
        } else {
            $item = $this->items[$offset];
        }

        // Store the key to cache for future call
        $this->cache[$offset] = $item;

        return $item;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function offsetSet($offset, $value)
    {
        return $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }


    /**
     * Check a key exists on container
     * @param $offset
     * @return bool
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * Get item from container
     * @param $property
     * @return mixed
     * @throws InvalidContainerKeyException
     */
    public function get(string $property)
    {
        return $this->offsetGet($property);
    }
}
