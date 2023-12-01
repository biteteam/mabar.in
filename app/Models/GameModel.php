<?php

namespace App\Models;

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Model;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\isNull;

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

    public function findAllGame(int $limit = 0, int $offset = 0, array $options = ['isVerifiedOnly' => false, 'isVerified' => null])
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        $allGames = $this->join($userTable, "$userTable.$userPK = {$this->table}.creator", "LEFT")
            ->select("
                {$this->table}.*,
                $userTable.id as creator,
                $userTable.name as creator_name,
                $userTable.username as creator_username,
                $userTable.photo as creator_photo")
            ->orderBy("{$this->table}.updated_at")
            ->orderBy("{$this->table}.is_verified");

        if (isset($options['isVerifiedOnly']) && $options['isVerifiedOnly']) $allGames = $allGames->where('is_verified', true);
        if (isset($options['isVerified']) && gettype($options['isVerified']) == 'boolean') $allGames = $allGames->where('is_verified', $options['isVerified']);

        return $allGames->findAll($limit, $offset);
    }

    public function findGameByUserId(string|int $userId, int $limit = 0, int $offset = 0)
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        $allGames = $this->join($userTable, "$userTable.$userPK = {$this->table}.creator", "LEFT")
            ->select("
                {$this->table}.*,
                $userTable.id as creator,
                $userTable.name as creator_name,
                $userTable.username as creator_username,
                $userTable.photo as creator_photo")
            ->where("$userTable.id", $userId)
            ->orderBy("{$this->table}.updated_at")
            ->orderBy("{$this->table}.is_verified")
            ->findAll($limit, $offset);

        return $allGames;
    }

    public function findGameByCode(string $gameCode): \stdClass|null
    {
        $userTable = UserModel::getConfigName('tableName');
        $userPK = UserModel::getConfigName('primaryKey');

        return $this->where('code', $gameCode)
            ->join($userTable, "$userTable.$userPK = {$this->table}.creator", "LEFT")
            ->select("
                {$this->table}.*,
                $userTable.id as creator,
                $userTable.name as creator_name,
                $userTable.username as creator_username,
                $userTable.photo as creator_photo")
            ->orderBy("{$this->table}.updated_at")
            ->orderBy("{$this->table}.is_verified")
            ->first();
    }

    public function updateGame(string|int $gameId, array $gameData): bool
    {
        try {
            // also Update team game.code

            return $this->update($gameId, $gameData);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteGame(string|int $gameId): BaseResult|bool
    {
        try {
            // also Edit team game.code

            return $this->delete($gameId);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Add new Game
     *
     * @param array $gameData
     * @return integer|boolean
     */
    public function addGame(array $gameData): int|bool
    {
        try {
            return $this->insert($gameData, true);
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
