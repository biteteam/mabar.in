<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        /**
         * If Authenticated   | return to dashboard view
         * If UnAuthenticated | return to homepage view
         */
        return view('homepage', [
            'metadata' => ['title' => "Cari Tim Mabar Game Terbaikmu"]
        ]);
    }
}
