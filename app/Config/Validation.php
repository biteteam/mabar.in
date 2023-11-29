<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $login = [
        'username' => [
            'rules'  => 'required|min_length[5]|max_length[16]',
            'errors' => [
                'required' => 'Username tidak boleh kosong.',
                'min_length' => 'Username harus minimal 5 karakter.',
                'max_length' => 'Username tidak boleh lebih dari 16 karakter.',
            ],
        ],
        'password' => [
            'rules'  => 'required|min_length[8]|max_length[132]',
            'errors' => [
                'required' => 'Password tidak boleh kosong.',
                'min_length' => 'Password harus minimal 8 karakter.',
                'max_length' => 'Password tidak boleh lebih dari 132 karakter.',
            ]
        ],
    ];
}
