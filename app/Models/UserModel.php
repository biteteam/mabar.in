<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Stmt\TryCatch;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'username', 'email', 'phone', 'photo', 'password', 'role'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Register a new User
     *
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string|null $phone
     * @param string|null $photo
     * @return mixed
     */
    public function registerUser(
        string $name,
        string $username,
        string $email,
        string $password,
        string $role = 'user',
        ?string $phone = null,
        ?string $photo = null
    ): int|bool {
        try {
            return $this->insert([
                'name'     => $name,
                'username' => $username,
                'email'    => $email,
                'phone'    => $phone ?? null,
                'photo'    => $photo ?? "https://ui-avatars.com/api?name=" . initial_name($name, "+") . "&color=7F9CF5&background=EBF4FF",
                'password' => auth(true)->hashCreds($password),
                'role'     => $role,
            ], true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getConfigName(string $configName = null): string|array
    {;
        $instance = new self();

        switch ($configName) {
            case 'tableName':
                return $instance->table;
            case 'primaryKey':
                return $instance->primaryKey;
            case 'createdField':
                return $instance->createdField;
            case 'updatedField':
                return $instance->updatedField;
            default:
                return [
                    'tableName'    => $instance->table,
                    'primaryKey'   => $instance->primaryKey,
                    'createdField' => $instance->createdField,
                    'updatedField' => $instance->updatedField,
                ];
        }
    }
}
