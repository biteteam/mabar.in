<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = model(UserModel::class);
    }

    public function main()
    {
        if (auth()->isUser()) return redirect("user.profile");

        $users = $this->user->orderBy('role', "DESC")->orderBy('created_at', "DESC")->findAll();
        return view('user/main', [
            'users'     => $users,
            'metadata'  => [
                'title'   => "Pengguna",
                'header'  => [
                    'title'        => 'Pengguna',
                    'description'  => 'Semua pengguna yang telah terdaftar.'
                ]
            ]
        ]);
    }

    public function selfProfile()
    {
        $userLoggedInId = auth()->user()->id;
        $user = $this->user
            ->withTotalAccounts()
            ->withTotalGames()
            ->withTotalTeams()
            ->find($userLoggedInId);

        return view('user/profile', [
            'user'      => $user,
            'metadata'  => [
                'title'   => "Profil",
                'header'  => [
                    'title'        => 'Profil',
                    'description'  => 'Profil kamu.'
                ]
            ]
        ]);
    }

    public function userProfile(int|string $usernameOrEmail)
    {
        if (strval($usernameOrEmail) == strval(auth()->user()->username) || strval($usernameOrEmail) == strval(auth()->user()->email))
            return redirect('user.profile');

        $user = $this->user
            ->findByUsernameOrEmail($usernameOrEmail, ['returning_model' => true])
            ->withTotalAccounts()
            ->withTotalGames()
            ->withTotalTeams()
            ->first();

        if (empty($user)) $this->session->setFlashdata('error', "Pengguna $usernameOrEmail tidak dapat ditemukan!");

        return view('user/detail', [
            'user'      => $user,
            'metadata'  => [
                'title'   => !empty($user) ? "Profil {$user->name} (@{$user->username})" : "Pengguna $usernameOrEmail tidak dapat ditemukan",
                'header'  => [
                    'title'        => 'Profil',
                    'description'  => 'Profil kamu.'
                ]
            ]
        ]);
    }
}
