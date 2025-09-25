<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');

$routes->get('logout', 'AuthController::logout');

$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::forgotPassword');

$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('reset-password', 'AuthController::resetPassword');
