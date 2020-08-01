<?php
namespace MiniPHP;

class Container implements \ArrayAccess
{
    protected $items = [];
    
    public function offsetSet($offset, $value)
    {
        $items[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $items[$offset];
    }

    public function offsetExists($offser)
    {
        return isset($items[$offset]);
    }

    public function offsetUnset($offser)
    {
        //
    }


    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    public function get($offset)
    {
        return $this->offsetGet($offset);
    }
}