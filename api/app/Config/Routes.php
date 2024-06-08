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

$routes->get('menubar', 'Menubar::index');
$routes->get('menubar/buscar', 'Menubar::buscar');

$routes->group('menu', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('index', 'Menu::index');
    $routes->get('buscar', 'Menu::buscar');
});

$routes->get('catalogo', 'Catalogo::index');
$routes->get('catalogo/ver_lista', 'Catalogo::ver_lista');

$routes->group('recepcion', function($routes) {
    $routes->get('principal', 'Principal::index');
    $routes->get('principal/buscar', 'recepcion\Principal::buscar');
    $routes->get('principal/get_datos', 'recepcion\Principal::get_datos');
    $routes->post('principal/guardar/(:segment)', 'recepcion\Principal::guardar/$1');
    $routes->post('principal/guardar', 'recepcion\Principal::guardar');
    $routes->post('principal/recibir', 'recepcion\Principal::recibir');
});