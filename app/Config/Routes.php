<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------------------------------------------------------
// Routes Publiques
// --------------------------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('creneaux', 'ClientController::creneaux');

// --------------------------------------------------------------------
// Routes d'Authentification
// --------------------------------------------------------------------
// On groupe ces routes même sans préfixe d'URL pour des raisons d'organisation
$routes->group('', static function ($routes) {
    $routes->match(['get', 'post'], 'inscription', 'AuthController::register');
    $routes->match(['get', 'post'], 'connexion', 'AuthController::login');
    $routes->get('deconnexion', 'AuthController::logout');
});

// --------------------------------------------------------------------
// Espace Client (Préfixe : /client)
// --------------------------------------------------------------------
$routes->group('client', static function ($routes) {
    // L'URL réelle sera /client/dashboard
    $routes->get('dashboard', 'ClientController::dashboard');

    // L'URL réelle sera /client/reserver/12
    $routes->get('reserver/(:num)', 'ClientController::reserver/$1');
    $routes->get('annuler/(:num)', 'ClientController::annuler/$1');
});

// --------------------------------------------------------------------
// Espace Administrateur (Préfixe : /admin) - Pour la prochaine étape
// --------------------------------------------------------------------
$routes->group('admin', static function ($routes) {
    // Nous remplirons ce groupe tout à l'heure
    // $routes->get('dashboard', 'AdminController::dashboard');
});