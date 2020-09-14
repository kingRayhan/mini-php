<?php

namespace MiniPHP;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * MiniPHP Database ORM
 * Class Orm
 * @package MiniPHP
 * @author KingRayhan
 */
class Orm
{
    private $orm;

    /**
     * Orm constructor.
     */
    public function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => env('DB_DRIVER', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_NAME', 'miniphp'),
            'username' => env('DB_USER', 'postgres'),
            'password' => env('DB_PASS'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);


        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        $this->orm = $capsule;
    }


    /**
     * @return mixed
     */
    public function boot()
    {
        return $this->orm;
    }
}