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
                'min_length' => 'Password harus minimal 8 karakter.Password harus minimal 8 karakter. ',
                'max_length' => 'Password tidak boleh lebih dari 132 karakter.',
            ]
        ],
    ];

    public array $register = [
        'name' => [
            'rules'  => 'required|min_length[4]|max_length[32]',
            'errors' => [
                'required'    => 'Nama tidak boleh kosong.',
                'min_length'  => 'Nama harus minimal 4 karakter.',
                'max_length'  => 'Nama tidak boleh lebih dari 32 karakter.',
            ],
        ],
        'username' => [
            'rules'  => 'required|min_length[5]|max_length[16]|is_unique[users.username]|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'errors' => [
                'required'    => 'Username tidak boleh kosong.',
                'min_length'  => 'Username harus minimal 5 karakter.',
                'max_length'  => 'Username tidak boleh lebih dari 16 karakter.',
                'is_unique'   => 'Username sudah digunakan, pilih username yang lain.',
                'regex_match' => 'Username hanya boleh mengandung huruf, angka, underscore (_) dan dot (.)'
            ],
        ],
        'email' => [
            'rules'  => 'required|min_length[3]|max_length[64]|valid_email|is_unique[users.email]',
            'errors' => [
                'required'    => 'Email tidak boleh kosong.',
                'min_length'  => 'Email harus minimal 4 karakter.',
                'max_length'  => 'Email tidak boleh lebih dari 64 karakter.',
                'valid_email' => 'Email harus merupakan alamat email yang valid.',
                'is_unique'   => 'Email sudah digunakan, gunakan alamat email yang lain.'
            ],
        ],
        'password' => [
            'rules'  => 'required|min_length[8]|max_length[132]',
            'errors' => [
                'required'   => 'Password tidak boleh kosong.',
                'min_length' => 'Password harus minimal 8 karakter.',
                'max_length' => 'Password tidak boleh lebih dari 132 karakter.',
            ]
        ],
        'retype_password' => [
            'rules'  => 'required|min_length[8]|max_length[132]|matches[password]',
            'errors' => [
                'required'   => 'Ulangi Password tidak boleh kosong.',
                'min_length' => 'Ulangi Password harus minimal 8 karakter.',
                'max_length' => 'Ulangi Password tidak boleh lebih dari 132 karakter.',
                'matches'    => 'Ulangi Password harus sama dengan Password.'
            ]
        ],
    ];
}
