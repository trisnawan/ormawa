<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/logout', 'Home::logout');
$routes->get('/login', 'Home::login');
$routes->post('/login', 'Home::login');
$routes->get('/registration', 'Home::registration');
$routes->post('/registration', 'Home::registration');

$routes->get('/chat/(:any)', 'Chat::open/$1');