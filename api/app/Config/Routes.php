<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// app/Config/Routes.php

$routes->post('api/sesion/login', 'Sesion::login');
$routes->post('api/sesion/logout', 'Sesion::logout');
$routes->post('api/sesion/validar_token', 'Sesion::validar_token');
$routes->get('api/sesion', 'Sesion::index');

