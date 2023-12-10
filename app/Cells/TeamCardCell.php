<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class TeamCardCell extends Cell
{
    public $team;

    public $includeSelf;
    protected string $view = "components/team-card";

    public function mount()
    {
        if (!empty($this->team->members)) {
            $includeSelfId = array_map(fn ($member) => intval($member->account->user->id) == intval(auth()->user()->id), $this->team->members);
            // dd($this->team);
            $this->includeSelf = boolval(reset($includeSelfId));
        }
    }
}
