<?php


namespace MiniPHP\Controllers;

use MiniPHP\models\User;
use MiniPHP\StatusCodes;

class ParcelController
{

    public function index()
    {
        $users = User::all();
        return response()->withJSON($users)->withStatus(StatusCodes::HTTP_CREATED);
    }


    public function store()
    {
        $user = User::create(request()->only(['name']));
        return response()->withJSON($user);
    }
}