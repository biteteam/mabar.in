<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Stmt\TryCatch;

class UserModel extends Model
{
    public static array $availableRole = ['user', 'admin'];
    public static string $defaultRole = 'user';
    public static string $superRole = 'admin';

    protected $table            = 'users';
    protected $tableSingular    = 'user';

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
                'photo'    => $photo ?? self::getDefaultAvatar($name),
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
            case 'tableSingular':
                return $instance->tableSingular;
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

    public static function getAvatarAmikomA22(string $nim): string
    {
        $formattedUriNim = preg_replace("/\./i", "_", $nim);
        return "https://fotomhs.amikom.ac.id/2022/$formattedUriNim.jpg";
    }

    public static function getDefaultAvatar(string $name, string $color = "7F9CF5", string $background = "EBF4FF"): string
    {
        $initialName = initial_name($name, "+");
        return "https://ui-avatars.com/api?name=$initialName&color=$color&background=$background";
    }
}
