<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication
$routes->get('register', 'AuthController::register', ['filter' => 'guest']);
$routes->post('register', 'AuthController::register', ['filter' => 'guest']);
$routes->get('/', 'AuthController::login', ['filter' => 'guest']);
$routes->post('/', 'AuthController::login', ['filter' => 'guest']);
$routes->get('forgot-password', 'AuthController::forgotPassword', ['filter' => 'guest']);
$routes->post('forgot-password', 'AuthController::forgotPassword', ['filter' => 'guest']);
$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1', ['filter' => 'guest']);
$routes->post('reset-password', 'AuthController::resetPassword', ['filter' => 'guest']);
$routes->get('logout', 'AuthController::logout');
$routes->get('unauthorized', 'AuthController::unauthorized');

// Resident
$routes->get('resident/dashboard', 'ResidentController::dashboard', ['filter' => 'role:resident']);
$routes->get('resident/profile', 'ResidentController::profile', ['filter' => 'role:resident']);
$routes->post('resident/profile', 'ResidentController::profile', ['filter' => 'role:resident']);

// Staff
$routes->get('staff/manage-residents', 'StaffController::manageResidents', ['filter' => 'role:staff']);

// Admin
$routes->get('admin/dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']);
