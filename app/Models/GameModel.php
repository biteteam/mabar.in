<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table            = 'games';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'creator', 'name', 'description', 'image', 'max_player', 'is_verified'];

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

    public function findAllGame(int $limit = 0, int $offset = 0)
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        $allGames = $this->join($userTable, "$userTable.$userPK = {$this->table}.creator", "LEFT")
            ->select("
                {$this->table}.*,
                $userTable.name as creator,
                $userTable.id as creator_id,
                $userTable.username as creator_username,
                $userTable.photo as creator_photo")
            ->orderBy("{$this->table}.updated_at")
            ->orderBy("{$this->table}.is_verified")
            ->findAll($limit, $offset);

        return $allGames;
    }

    public function findGameByUserId(string|int $userId, int $limit = 0, int $offset = 0)
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        $allGames = $this->join($userTable, "$userTable.$userPK = {$this->table}.creator", "LEFT")
            ->select("
                {$this->table}.*,
                $userTable.name as creator,
                $userTable.id as creator_id,
                $userTable.username as creator_username,
                $userTable.photo as creator_photo")
            ->where("$userTable.id", $userId)
            ->orderBy("{$this->table}.updated_at")
            ->orderBy("{$this->table}.is_verified")
            ->findAll($limit, $offset);

        return $allGames;
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
