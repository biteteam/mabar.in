<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{

    public function __construct()
    {
        $this->helpers = ['form'];
    }

    public function index()
    {
        return redirect('login');
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('login');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'username'  => $this->validation->getError('username'),
                    'password'  => $this->validation->getError('password'),
                ];
            }

            $user = $this->validation->getValidated();
            if ($user) {
                // Logic Login Session Here
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Username atau Kata Sandi salah!"]);
        }

        return view("auth/login", [
            'metadata' => ['title' => "Login"],
            'error'    => $this->session->getFlashdata('error')
        ]);
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
