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

$routes->group('usuario', function($routes) {
    $routes->get('buscar', 'Usuario::buscar');
    $routes->post('guardar/(:num)', 'Usuario::guardar/$1');
    $routes->post('guardar', 'Usuario::guardar');
    $routes->post('anular_usuario/(:num)', 'Usuario::anular_usuario/$1');
});
