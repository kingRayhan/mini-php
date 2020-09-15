<?php

namespace MiniPHP\models;

use Illuminate\Database\Eloquent\Model;

/**
 * User Model
 * @package MiniPHP\models
 */
class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name'];
}