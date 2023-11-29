<?php

namespace App\Database\Seeds;

use App\Library\AuthLibrary;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\{Factory as FakerFactory};

class UserSeeder extends Seeder
{
    protected int $seedCount = 20;

    public function run()
    {
        $tableName = UserModel::getConfigName('tableName');
        $faker = FakerFactory::create('id_ID');
        $auth = auth(true);

        $defaultPassword = $auth->hashCreds("supersecret");
        $defaultAdmins = [
            [
                'name' => 'Fiki Pratama',
                'username' => 'nsmle',
                'email'    => 'fikipratama@students.amikom.ac.id',
                'phone'    => '+6289531538005',
                'photo'    => 'https://fotomhs.amikom.ac.id/2022/22_12_2551.jpg',
                'password' => $auth->hashCreds('nsmlesleep'),
                'role'     => 'admin',

            ]
        ];

        foreach ($defaultAdmins as $admin) {
            $this->db->table($tableName)->insert($admin);
        }

        $adminCount = 1;
        for ($i = 0; $i < $this->seedCount; $i++) {
            $gender = $faker->randomElements(['male', 'female'])[0];
            $role = $faker->randomElements(['admin', 'user'])[0];
            $name = $faker->name($gender);

            if ($role == 'admin') $adminCount += 1;
            if ($adminCount > 3) $role = 'user';

            $user = [
                'name'     => $name,
                'username' => $faker->userName(),
                'email'    => $faker->unique()->email(),
                'phone'    => $faker->unique()->e164PhoneNumber(),
                'photo'    => "https://ui-avatars.com/api?name=" . initial_name($name, "+") . "&color=7F9CF5&background=EBF4FF",
                'password' => $defaultPassword,
                'role'     => $role,
            ];

            $this->db->table($tableName)->insert($user);
        }
    }
}
