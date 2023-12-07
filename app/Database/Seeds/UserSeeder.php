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
                'name'     => 'Fiki Pratama',
                'username' => 'nsmle',
                'email'    => 'fikipratama@students.amikom.ac.id',
                'phone'    => '+6289531538005',
                'photo'    => UserModel::getAvatarAmikomA22("22.12.2551"),
                'password' => $auth->hashCreds('nsmlesleep'),
                'role'     => UserModel::$superRole,
            ],
            [
                'name'     => 'Realino Primanda Prasano',
                'username' => 'realino',
                'email'    => 'realino@students.amikom.ac.id',
                'phone'    => '+6282255556666',
                'photo'    => UserModel::getAvatarAmikomA22("22.12.2548"),
                'password' => $auth->hashCreds('primandaprasano'),
                'role'     => UserModel::$defaultRole,
            ],
            [
                'name'     => 'Zulafan Fadhlan Widadi',
                'username' => 'zulafan',
                'email'    => 'zulafan@students.amikom.ac.id',
                'phone'    => '+6282466662222',
                'photo'    => UserModel::getAvatarAmikomA22("22.12.2568"),
                'password' => $auth->hashCreds('fadhlanwidadi'),
                'role'     => UserModel::$superRole,
            ],
            [
                'name'     => 'Sabib Prastio',
                'username' => 'sabib',
                'email'    => 'sabibprastio@students.amikom.ac.id',
                'phone'    => '+6282344448888',
                'photo'    => UserModel::getAvatarAmikomA22("22.12.2598"),
                'password' => $auth->hashCreds('sprastio'),
                'role'     => UserModel::$defaultRole,
            ],
            [
                'name'     => 'Rizka Amela Sari',
                'username' => 'rizka',
                'email'    => 'rizka@students.amikom.ac.id',
                'phone'    => '+6289677779999',
                'photo'    => UserModel::getAvatarAmikomA22("22.12.2603"),
                'password' => $auth->hashCreds('ameliasari'),
                'role'     => UserModel::$superRole,
            ],
            [
                'name'     => 'Admin',
                'username' => 'admin',
                'email'    => 'admin.amikom.ac.id',
                'phone'    => '+6289622224444',
                'photo'    => UserModel::getDefaultAvatar("Admin"),
                'password' => $auth->hashCreds('admin123'),
                'role'     => UserModel::$superRole,
            ],
        ];

        foreach ($defaultAdmins as $admin) {
            $this->db->table($tableName)->insert($admin);
        }

        $adminCount = 1;
        for ($i = 0; $i < $this->seedCount; $i++) {
            $gender = $faker->randomElements(['male', 'female'])[0];
            $role = $faker->randomElements(UserModel::$availableRole)[0];
            $name = $faker->name($gender);

            if ($role == UserModel::$superRole) $adminCount += 1;
            if ($adminCount > 3) $role = UserModel::$defaultRole;

            $user = [
                'name'     => $name,
                'username' => $faker->userName(),
                'email'    => $faker->unique()->email(),
                'phone'    => $faker->unique()->e164PhoneNumber(),
                'password' => $defaultPassword,
                'photo'    => UserModel::getDefaultAvatar($name),
                'role'     => $role,
            ];

            $this->db->table($tableName)->insert($user);
        }
    }
}
