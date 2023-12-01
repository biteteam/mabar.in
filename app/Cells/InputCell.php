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
    public $className;
    public $rows;
    public $cols;

    protected string $view = "components/input";
}
