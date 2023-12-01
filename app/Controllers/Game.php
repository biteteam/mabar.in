<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GameModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use Error;
use PhpParser\Node\Stmt\TryCatch;

use function PHPSTORM_META\map;

class Game extends BaseController
{
    protected GameModel $game;

    public function __construct()
    {
        $this->game = model(GameModel::class);
    }

    public function index()
    {
        $limit = $this->request->getVar('limit') ?? 100;
        $data  = [
            'all' => $this->game->findAllGame($limit),
            'own' => [],
        ];

        if (auth()->isLoggedIn()) {
            $userId = auth()->user()->id;
            $data['own'] = $this->game->findGameByUserId($userId, $limit);

            $data = $this->duplicateGameFilter($data['all'], $data['own']);
        }

        return view('game/main', [
            'games'     => $data,
            'metadata'  => [
                'title'   => "Game",
                'header'  => [
                    'title'        => 'Game',
                    'description'  => 'Lihat semua game yang tersedia, kami akan menambahkan game lainnya di waktu mendatang.'
                ]
            ]
        ]);
    }

    public function addGame()
    {
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('login');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'game_verified'  => $this->validation->getError('game_verified'),
                    'game_creator'  => $this->validation->getError('game_creator'),
                    'game_image'  => $this->validation->getError('game_image'),
                    'game_name'  => $this->validation->getError('game_name'),
                    'game_code'  => $this->validation->getError('game_code'),
                    'game_description'  => $this->validation->getError('game_description'),
                    'game_max_player'  => $this->validation->getError('game_max_player'),
                ];
            }
        }

        return view('game/add', [
            'metadata'  => [
                'title'   => "Tambah Game",
                'header'  => [
                    'title'        => 'Tambah Game',
                    'description'  => 'Tambah game favoritmu.'
                ]
            ]
        ]);
    }

    /**
     * Upload Game Image
     * 
     * Game image upload by route /game/upload-image, or
     * Call this method manual from another method 
     *
     * @param UploadedFile|null $uploadedFile
     * @return void
     */
    public function uploadImage(?UploadedFile $uploadedFile = null)
    {
        if (!empty($uploadedFile)) {
            $file = $uploadedFile;
        } else {
            if (!$this->request->is("post")) return $this->response->setJSON(['status' => 'error', 'message' => 'Must be use POST method!']);
            $file = $this->request->getFile('game_image');
        }

        try {
            if (!$file->isValid()) throw new Error("Gambar game invalid, pastikan file yang di upload berupa gambar!");
            if ($file->hasMoved()) throw new Error("File gambar telah di upload sebelumnya!");

            $fileName = $file->getRandomName();
            if (ENVIRONMENT == 'development') $fileName = $file->getName();

            $gamePath = 'game/';
            $uploadPath = IMAGEPATH . $gamePath;

            $previewUri = base_url("img/$gamePath/$fileName");

            $isMoved = $file->move($uploadPath, $fileName, (bool)(ENVIRONMENT == 'development'));
            if (!$isMoved) throw new Error("Gagal upload gambar game, File gagal dipindahkan!");

            if (!empty($uploadedFile)) return true;
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'message' => 'Game image uploaded!',
                'preview'   => $previewUri
            ]);
        } catch (\Throwable $th) {
            if (!empty($uploadedFile)) return false;
            $errMsg = $th->getMessage();
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => $errMsg ?? 'Upload gambar game gagal!'
            ]);
        }
    }


    /**
     * Filter Duplicate Game Data
     *
     * @param array $allGamesData
     * @param array $ownGamesData
     * @return array
     */
    private function duplicateGameFilter(array $allGamesData, array $ownGamesData): array
    {
        // Array of id game
        $ownGamesId = array_map(function ($ownGame) {
            return $ownGame->id;
        }, $ownGamesData);

        $allGamesData = array_filter($allGamesData, function ($allGame) use ($ownGamesId) {
            if (!in_array($allGame->id, $ownGamesId)) return $allGame;
        });

        return [
            'all' => $allGamesData,
            'own' => $ownGamesData,
        ];
    }
}
