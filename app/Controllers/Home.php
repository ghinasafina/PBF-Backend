<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function save($name="")
    {
        echo "halo nama saya $name";
    }
}
