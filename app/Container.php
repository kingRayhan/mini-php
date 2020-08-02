<?php
namespace MiniPHP;

use ArrayAccess;
use Closure;

class Container implements ArrayAccess
{
    /**
     * @var array Array of container items
     */
    protected $items = [];

    /**
     * @var array item cache
     */
    protected $caches = [];


    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if(!$this->has($offset)) return null;

        $item = null;

        if(isset($this->caches[$offset])) { $item = $this->caches[$offset]; }
        else{ $item = $this->items[$offset]; }

        // https://stackoverflow.com/a/7101568/3705299
        return $item instanceof Closure ? $item($this) : $item;
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
        if($this->has($offset))
            unset($this->items[$offset]);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param $offset
     * @return boolean
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * @param $offset
     */
    public function remove($offset)
    {
        if($this->has($offset))
            $this->offsetUnset($offset);
    }

    /**
     * @param $offset
     * @return mixed|null
     */
    public function __get($offset)
    {
        return $this->get($offset);
    }
}