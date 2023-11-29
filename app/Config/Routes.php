<?php

use App\Controllers\Auth;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index'], ['as' => 'home']);

// Authentication Routes
$routes->group('auth', static function ($route) {
    $route->get('/', [Auth::class, 'index']);
    $route->post('logout', [Auth::class, 'logout'], ['as' => 'logout']);
    $route->match(['get', 'post'], 'login', [Auth::class, 'login'], ['as' => 'login']);
    $route->match(['get', 'post'], 'register', [Auth::class, 'register'], ['as' => 'register']);
});
