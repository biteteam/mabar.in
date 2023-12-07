<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeamModel;

class Team extends BaseController
{
    protected TeamModel $team;

    public function __construct()
    {
        $this->team = model(TeamModel::class);
    }

    public function main()
    {
        $teams['recruite'] = $this->team->where('status', 'recruite')->findAllTeams();
        $teams['matches'] = $this->team->where('status', 'matches')->findAllTeams();
        $teams['archive'] = $this->team->where('status', 'archive')->findAllTeams();

        if (auth()->isAdmin()) $teams['draft'] = $this->team->where('status', 'draft')->findAllTeams();

        return view('team/main', [
            'team' => $teams,
            'metadata'  => [
                'title'   => "Team",
                'header'  => [
                    'title'        => 'Team',
                    'description'  => 'Lihat semua tim dari berbagai game yang di pertemukan di sini.'
                ]
            ]
        ]);
    }
}
