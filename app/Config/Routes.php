<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['get', 'post'], 'inscription', 'AuthController::register');
$routes->match(['get', 'post'], 'connexion', 'AuthController::login');
$routes->get('deconnexion', 'AuthController::logout');
$routes->get('client/dashboard', 'ClientController::dashboard');
