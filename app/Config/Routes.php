<?php

use App\Controllers\Auth;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->group('auth', static function ($route) {
    $route->get("/", [Auth::class, 'index']);
    $route->match(['get', 'post'], "login", [Auth::class, 'login'], ['as' => 'login']);
    $route->match(['get', 'post'], "register", [Auth::class, 'register'], ['as' => 'register']);
});
