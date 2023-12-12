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
        $user = $this->user->where('id', auth()->user()->id)->first();
    }

    public function userProfile(int|string $username)
    {
        $user = $this->user->where('username', $username)->first();
    }
}
