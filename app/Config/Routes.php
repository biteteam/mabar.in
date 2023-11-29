<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Auth, Game, Home};

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
    // Game
    $route->get('', [Game::class, "index"], ['as' => 'game']);
    $route->match(['get', 'post'], 'add', [Game::class, "addGame"], ['as' => 'game.add']);
    $route->match(['get', 'post'], '(:any)/edit', [Game::class, "editGame"], ['as' => 'game.edit']);
    $route->post('(:any)/delete', [Game::class, "editGame"], ['as' => 'game.edit']);

    // Account Game
    $route->get('account', [Game::class, "account"], ['as' => 'game.account']);
    $route->match(['get', 'post'], 'account/add', [Game::class, "addAccount"], ['as' => 'game.account.add']);
    $route->match(['get', 'post'], 'account/(:any)/edit', [Game::class, "editAccount"], ['as' => 'game.account.edit']);
    $route->post('account/(:any)/delete', [Game::class, "deleteAccount"], ['as' => 'game.account.delete']);
});
