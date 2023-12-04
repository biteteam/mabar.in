<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GameAccountModel;
use App\Models\GameModel;
use App\Models\UserModel;

class GameAccount extends BaseController
{
    protected UserModel $user;
    protected GameModel $game;
    protected GameAccountModel $account;

    public function __construct()
    {
        $this->user = model(UserModel::class);
        $this->game = model(GameModel::class);
        $this->account = model(GameAccountModel::class);
    }

    public function index()
    {
        $data['accounts'] = $this->account->where('user =', auth()->user('id'))->findAllAccounts();

        if (auth()->isAdmin()) {
            $data['allUserAccounts'] = $this->account->where('user !=', auth()->user('id'))->where("status", 'verified')->findAllAccounts();
            $data['allUnverifiedAccounts'] = $this->account->where('user !=', auth()->user('id'))->where("status !=", 'verified')->findAllAccounts();
        }

        return view('game/account/main', [
            ...$data,
            'metadata'        => [
                'title'   => "Akun Game",
                'header'  => [
                    'title'        => 'Akun Game',
                    'description'  => 'Lihat akun game yang telah kamu hubungkan.'
                ]
            ]
        ]);
    }

    public function addAccount()
    {

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('gameAccount');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'account_game'              => $this->validation->getError('account_game'),
                    'account_user'              => $this->validation->getError('account_user'),
                    'account_status'            => $this->validation->getError('account_status'),
                    'account_identity'          => $this->validation->getError('account_identity'),
                    'account_identity_zone_id'  => $this->validation->getError('account_identity_zone_id'),
                ];
            }

            $accountValidated = $this->validation->getValidated();
            $accountData = $this->serialize($accountValidated);

            if (!empty($accountData)) {
                if ($accountData['status'] == "verified" && auth()->isUser())
                    $validationErrors['account_status'] = "Kamu tidak memiliki akses untuk memverifikasi";

                if (intval($accountData['user']) !==  intval(auth()->user('id')))
                    $validationErrors['account_user'] = "Kamu hanya boleh menambahkan akun untuk pengguna yang sedang login saat ini.";

                $isAccountExist = $this->account->findAccountByIdentity($accountData['identity'], $accountData['game'], ["gameType" => "id", "withGame" => true, "withUser" => true]);
                if ($isAccountExist) $validationErrors['account_identity'] = "User Id akun pada game ini sudah digunakan, silahkan gunakan user id yang lain!";
            }

            if ($accountData && empty($validationErrors)) {

                $isAccountAdded = $this->account->addAccount($accountData);

                if ($isAccountAdded) {
                    $this->session->setFlashdata('toast_success', "Berhasil menambahkan akun game.");
                    return redirect('game.account');
                }
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal menambahkan akun, Silahkan Coba Lagi!"]);
        }

        return view('game/account/add', [
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => "Tambah Akun Game",
                'header'  => [
                    'title'        => 'Tambah Akun Game',
                    'description'  => 'Tambah akun game favoritmu.'
                ]
            ],
        ]);
    }

    public function editAccount($gameCode, $identity)
    {
        $account = $this->account->findAccountByIdentity($identity, $gameCode);
        if (empty($account)) {
            $this->session->setFlashdata('toast_error', "Akun game $gameCode dengan user id $identity tidak ditemukan!");
            return redirect('game.account');
        }

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('gameAccount');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'account_game'              => $this->validation->getError('account_game'),
                    'account_user'              => $this->validation->getError('account_user'),
                    'account_status'            => $this->validation->getError('account_status'),
                    'account_identity'          => $this->validation->getError('account_identity'),
                    'account_identity_zone_id'  => $this->validation->getError('account_identity_zone_id'),
                ];
            }

            $accountValidated = $this->validation->getValidated();
            $accountData = $this->serialize($accountValidated);

            if (!empty($accountData)) {
                if ($accountData['user'] !== $account->user->id && auth()->isUser())
                    $validationErrors['account_user'] = "Kamu bukan merupakan pemilik sah dari game ini!";
                if ($accountData['status'] !== $account->status && auth()->isUser())
                    $validationErrors['game_is_verified'] = "Kamu tidak memiliki akses untuk verifikasi akun game!";
                if ($accountData['identity'] !== $account->identity || $accountData['game'] !== $account->game->id) {
                    $isAccountExist = $this->account->findAccountByIdentity($accountData['identity'], $accountData['game'], ["gameType" => "id", "withGame" => true, "withUser" => true]);
                    if ($isAccountExist) $validationErrors['account_identity'] = "User Id akun pada game ini sudah digunakan, silahkan gunakan user id yang lain!";
                }

                if (auth()->isUser()) $accountData['status'] = 'unverified';
            }

            if ($accountData && empty($validationErrors)) {
                $isAccountUpdate = $this->account->updateAccount($account->id, $accountData);
                if ($isAccountUpdate) {
                    $this->session->setFlashdata('toast_success', "Berhasil mengedit akun game!");
                    return redirect('game.account');
                }
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal menambahkan akun, Silahkan Coba Lagi!"]);
        }

        return view('game/account/edit', [
            'error'    => $this->session->getFlashdata('error'),
            'account'  => $account,
            'metadata' => [
                'title'   => "Edit Akun Game",
                'header'  => [
                    'title'        => 'Edit Akun Game',
                    'description'  => 'Edit akun untuk game' . $account->game->name . ""
                ]
            ]
        ]);
    }

    public function verifyAccount($gameCode, $identity)
    {
        if (auth()->isUser()) {
            $this->session->setFlashdata('toast_error', "Kamu tidak memiliki akses untuk verifikasi akun!");
            return redirect('game.account');
        }

        $account = $this->account->findAccountByIdentity($identity, $gameCode);
        if (empty($account)) {
            $this->session->setFlashdata('toast_error', "Akun game $gameCode dengan user id $identity tidak ditemukan!");
            return redirect('game.account');
        }

        $isVerified = $this->account->updateAccount($account->id, array_merge(to_array($account), [
            'user' => $account->user->id,
            'game' => $account->game->id,
            'status' => 'verified',
        ]));

        $isVerified = boolval($isVerified);
        $this->session->setFlashdata($isVerified ? 'toast_success' : "toast_error", (($isVerified) ? "Berhasil" : "Gagal") . " memverifikasi akun {$account->identity} yang dimiliki {$account->user->name} di game {$account->game->name}!");

        return redirect('game.account');
    }

    public function deleteAccount($gameCode, $identity)

    {
        $account = $this->account->findAccountByIdentity($identity, $gameCode);
        if (empty($account)) {
            $this->session->setFlashdata('toast_error', "Akun game $gameCode dengan user id $identity tidak ditemukan!");
            return redirect('game.account');
        } else if (auth()->isUser() && intval($account->user->id) !== intval(auth()->user('id'))) {
            $this->session->setFlashdata('toast_error', "Kamu tidak memiliki akses untuk menghapus akun $account->id!");
            return redirect('game.account');
        }

        $isDeleted = $this->account->deleteAccount($account->id);
        $this->session->setFlashdata($isDeleted ? 'toast_success' : "toast_error", (($isDeleted) ? "Berhasil" : "Gagal") . " menghapus akun {$account->identity} di game {$account->game->name}!");

        return redirect('game.account');
    }



    private function serialize(array $accountValidated)
    {
        $account = [];
        foreach ($accountValidated as $accountKey => $accountValue) {
            if (is_numeric($accountValue)) {
                $account[str_replace("account_", "", $accountKey)] = intval($accountValue);
                continue;
            }

            $account[str_replace("account_", "", $accountKey)] = $accountValue;
        }

        return $account;
    }
}
