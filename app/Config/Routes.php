<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Auth, Game, GameAccount, Home};

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index'], ['as' => 'home']);


// Authentication Routes
$routes->group('auth', static function ($route) {
    $route->get('', [Auth::class, 'index']);
    $route->post('logout', [Auth::class, 'logout'], ['as' => 'logout']);
    $route->match(['get', 'post'], 'login', [Auth::class, 'login'], ['as' => 'login']);
    $route->match(['get', 'post'], 'register', [Auth::class, 'register'], ['as' => 'register']);
});

// Game Routes
$routes->group('game', static function ($route) {
    // Account Game Routes
    $route->group('account', static function ($route) {
        $route->get('', [GameAccount::class, "index"], ['as' => 'game.account']);
        $route->match(['get', 'post'], 'add', [GameAccount::class, "addAccount"], ['as' => 'game.account.add']);
    });
    $route->group('(:any)/account', static function ($route) {
        $route->match(['get', 'post'], '(:any)/edit', [GameAccount::class, "editAccount"], ['as' => 'game.account.edit']);
        $route->post('(:any)/verify', [GameAccount::class, "verifyAccount"], ['as' => 'game.account.verify']);
        $route->post('(:any)/delete', [GameAccount::class, "deleteAccount"], ['as' => 'game.account.delete']);
    });

    // Game
    $route->get('', [Game::class, "index"], ['as' => 'game']);
    $route->get('(:any)/detail', [Game::class, "detailGame"], ['as' => 'game.detail']);
    $route->match(['get', 'post'], 'add', [Game::class, "addGame"], ['as' => 'game.add']);
    $route->match(['get', 'post'], '(:any)/edit', [Game::class, "editGame"], ['as' => 'game.edit']);
    $route->match(['get', 'post'], '(:any)/verify', [Game::class, "editGame"], ['as' => 'game.verify']);
    $route->post('(:any)/delete', [Game::class, "deleteGame"], ['as' => 'game.delete']);
    $route->post('upload-image', [Game::class, "uploadImage"], ['as' => 'game.upload-image']);
});

// Team Routes
$routes->group('team', static function ($route) {
    // Team Route
    $route->get('', [GameAccount::class, "index"], ['as' => 'team']);
    $route->get('/(:any)/detail', [GameAccount::class, "index"], ['as' => 'team.detail']);
    $route->match(['get', 'post'], '/add', [GameAccount::class, "addTeam"], ['as' => 'team.add']);
    $route->match(['get', 'post'], '/(:any)/edit', [GameAccount::class, "editTeam"], ['as' => 'team.edit']);
    $route->post('account/(:any)/delete', [GameAccount::class, "deleteTeam"], ['as' => 'team.delete']);

    // Team Member Route
});

// User Routes
$routes->group('user', static function ($route) {
    $route->get('', [Game::class, "index"], ['as' => 'user']);
    $route->get('(:any)/', [Game::class, "index"], ['as' => 'user.detail']);
});
