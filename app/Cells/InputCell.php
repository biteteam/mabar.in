<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class InputCell extends Cell
{
    public $name;
    public $label;
    public $type;
    public $placeholder;
    public $value;
    public $required;
    public $errorMessage;

    protected string $view = "components/input";
}
