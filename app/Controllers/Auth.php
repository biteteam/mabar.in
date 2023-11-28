<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        return redirect('login');
    }

    public function login()
    {
        echo "login";
    }

    public function logout()
    {
        echo "logout";
    }

    public function register()
    {
        echo "register";
    }
}
