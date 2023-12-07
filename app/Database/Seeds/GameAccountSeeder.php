<?php

namespace App\Database\Seeds;

use App\Models\GameAccountModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class GameAccountSeeder extends Seeder
{
    protected int $seedCount = 20;

    public function run()
    {
        $faker =  FakerFactory::create('id_ID');
        $tableName = GameAccountModel::getConfigName("tableName");
        $availableAccountStatus = GameAccountModel::$availableStatus;

        for ($i = 1; $i <= $this->seedCount; $i++) {
            $this->db->table($tableName)->insert([
                'user' => $faker->randomNumber(1, $this->seedCount),
                'game' => $faker->randomNumber(1, 2),
                'identity' => $faker->regexify('[0-9]{16}'),
                'identity_zone_id' => $faker->regexify('[0-9]{5}'),
                'status' => "ENUM({$availableAccountStatus})",
            ]);
        }
    }
}
