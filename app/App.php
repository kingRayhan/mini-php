<?php
namespace MiniPHP;

class App
{
    protected $container;

    public function __construct(){
        $this->container = new Container();
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}