<?php

namespace App\Database\Seeds;

use App\Models\GameModel;
use CodeIgniter\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run()
    {
        $tableName = GameModel::getConfigName('tableName');
        $games = [
            [
                'code'        => 'mobile-legends',
                'creator'     => 1,
                'name'        => 'Mobile Legends: Bang Bang',
                'description' => 'Mobile Legends: Bang Bang adalah permainan video seluler ber-genre multiplayer online battle arena yang dikembangkan dan diterbitkan oleh Moonton, anak perusahaan dari ByteDance.',
                'image'       => base_url('/img/game/mobile-legends-icon.jpg'),
                'max_player'  => 5,
                'is_verified' => true
            ],
            [
                'code'        => 'pubg-mobile',
                'creator'     => 1,
                'name'        => 'PUBG Mobile | #1 Battle Royale Mobile Game',
                'description' => "PUBG Mobile adalah sebuah permainan video battle royale gratis dimainkan yang dikembangkan oleh LightSpeed dan Quantum Studio, sebuah divisi dari Tencent Games. Ini merupakan adaptasi permainan piranti genggam dari PlayerUnknown's Battlegrounds yang dirilis untuk Android dan iOS pada tanggal 19 Maret 2018.",
                'image'       => base_url('/img/game/pubg-mobile-icon.png'),
                'max_player'  => 4,
                'is_verified' => true
            ]
        ];

        foreach ($games as $game) {
            $this->db->table($tableName)->insert($game);
        }

        foreach ($games as $game) {
            $game['code'] = "{$game['code']}-2";
            $game['creator'] = 2;
            $game['is_verified'] = false;
            $this->db->table($tableName)->insert($game);
        }

        foreach ($games as $game) {
            $game['code'] = "{$game['code']}-3";
            $game['creator'] = 3;
            $this->db->table($tableName)->insert($game);
        }
    }
}
