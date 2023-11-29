<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

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
        if (auth()->isLoggedIn()) {
            $this->session->setFlashdata('message', ['info' => 'Kamu sudah login sebelumnya, Silahkan logout untuk ganti akun!']);
            return redirect('home');
        };

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('login');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'username'  => $this->validation->getError('username'),
                    'password'  => $this->validation->getError('password'),
                ];
            }

            $userData = $this->validation->getValidated();
            $isUserCredentialsValid = auth()->validCreds($userData);
            if ($isUserCredentialsValid) {
                $user = auth()->user();
                $this->session->setFlashdata('message', ['info' => `Halo {$user->name}, Selamat datang kembali.`]);
                return redirect('home');
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Username atau Kata Sandi salah!"]);
        }

        return view("auth/login", [
            'metadata' => ['title' => "Login"],
            'error'    => $this->session->getFlashdata('error')
        ]);
    }

    public function logout(): RedirectResponse
    {
        return auth()->logout();
    }

    public function register()
    {
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('register');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'name'             => $this->validation->getError('name'),
                    'username'         => $this->validation->getError('username'),
                    'email'            => $this->validation->getError('email'),
                    'password'         => $this->validation->getError('password'),
                    'retype_password'  => $this->validation->getError('retype_password'),
                ];
            }

            $userData = $this->validation->getValidated();

            if ($userData && empty($validationErrors)) {
                // Logic Register Here
            }


            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Terjadi Kesalahan, Silahkan Coba Lagi!"]);
        }

        return view("auth/register", [
            'metadata' => ['title' => "Daftar"],
            'error'    => $this->session->getFlashdata('error')
        ]);
    }
}
