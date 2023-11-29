<?php

namespace App\Libraries;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use CodeIgniter\Session\Session;
use Config\Services;
use Config\Session as ConfigSession;

class AuthLibrary
{
    private const AUTH_UUID_SESSION_KEY = 'uuid';
    private const AUTH_USER_SESSION_KEY = 'user';
    private const AUTH_TIME_SESSION_KEY = 'expiredLoggedInTime';

    protected Session $session;
    protected UserModel $userModel;
    private \stdClass | null $userData = null;

    public function __construct(bool $silent = false)
    {
        $config = config(ConfigSession::class);
        $this->session = Services::session($config);
        if (!$silent) $this->userModel = model(UserModel::class);
    }

    public function validCreds(array $credentials): bool
    {
        if (empty($credentials['username']) || empty($credentials['password'])) return false;

        $user = $this->userModel
            ->where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();
        if (empty($user)) return false;

        $rawPassword = $credentials['password'];
        $encryptedPassword = $user->password;

        $isValid = password_verify($rawPassword, $encryptedPassword);
        if ($isValid) {
            $this->userData = $user;
            $this->session->set(self::AUTH_UUID_SESSION_KEY, $user->id);
            $this->session->set(self::AUTH_USER_SESSION_KEY, to_array($user));
            $this->session->set(self::AUTH_TIME_SESSION_KEY, Time::now()->addMonths(1)->getTimestamp());
        }

        return $isValid;
    }

    public function hashCreds(string $password)
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    public function user(): \stdClass
    {
        if (!empty($this->userData)) return $this->userData;

        if ($this->session->has(self::AUTH_USER_SESSION_KEY)) {
            $userSession = $this->session->get(self::AUTH_USER_SESSION_KEY);
            if (!empty($userSession)) return to_object($userSession);
        }

        if ($this->session->has(self::AUTH_UUID_SESSION_KEY)) {
            $userId = $this->session->get(self::AUTH_UUID_SESSION_KEY);
            $userData = $this->userModel->find($userId);
            if (!empty($userData)) {
                $this->userData = $userData;
                return $userData;
            }
        }

        return $this->userData;
    }

    public function isLoggedIn(): bool
    {
        if ($this->isEmptyAuthSession()) return false;

        $isExpired = $this->session->get(self::AUTH_TIME_SESSION_KEY) < Time::now()->getTimestamp();
        if ($isExpired) {
            $this->clearAuth();
            return false;
        }

        return true;
    }

    public function logout(string $routeRedirect = 'login'): RedirectResponse
    {
        $this->clearAuth();
        $this->userData = null;
        return redirect($routeRedirect);
    }

    private  function clearAuth(): void
    {
        $this->session->remove(self::AUTH_UUID_SESSION_KEY);
        $this->session->remove(self::AUTH_USER_SESSION_KEY);
        $this->session->remove(self::AUTH_TIME_SESSION_KEY);
    }


    private function isEmptyAuthSession(): bool
    {
        return !$this->session->has(self::AUTH_TIME_SESSION_KEY) ||
            !$this->session->has(self::AUTH_USER_SESSION_KEY) ||
            !$this->session->has(self::AUTH_UUID_SESSION_KEY);
    }
}
