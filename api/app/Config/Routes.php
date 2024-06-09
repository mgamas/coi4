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


$routes->group('recepcion', ['namespace' => 'App\Controllers\pedido'], function($routes) {
    $routes->get('detalle', 'Detalle::index');
    $routes->get('detalle/buscar', 'Detalle::buscar');
    $routes->post('detalle/guardar/(:segment)', 'Detalle::guardar/$1');
    $routes->post('detalle/guardar', 'Detalle::guardar');
    $routes->delete('detalle/eliminar_producto/(:segment)', 'Detalle::eliminar_producto/$1');
});

$routes->group('recepcion', ['namespace' => 'App\Controllers\recepcion'], function($routes) {
    $routes->get('detalle', 'Detalle::index');
    $routes->get('detalle/buscar', 'Detalle::buscar');
    $routes->post('detalle/guardar/(:segment)', 'Detalle::guardar/$1');
    $routes->post('detalle/guardar', 'Detalle::guardar');
    $routes->post('detalle/guardar_detalle', 'Detalle::guardar_detalle');
    $routes->delete('detalle/eliminar_producto/(:segment)', 'Detalle::eliminar_producto/$1');
    $routes->get('principal', 'Principal::index');
    $routes->get('principal/buscar', 'Principal::buscar');
    $routes->get('principal/get_datos', 'Principal::get_datos');
    $routes->post('principal/guardar/(:segment)', 'Principal::guardar/$1');
    $routes->post('principal/guardar', 'Principal::guardar');
    $routes->post('principal/recibir', 'Principal::recibir');
});

$routes->group('producto', ['namespace' => 'App\Controllers\producto'], function($routes) {
    $routes->get('unidad_medida', 'Unidad_medida::index');
    $routes->get('unidad_medida/buscar', 'Unidad_medida::buscar');
    $routes->post('unidad_medida/guardar/(:segment)', 'Unidad_medida::guardar/$1');
    $routes->post('unidad_medida/guardar', 'Unidad_medida::guardar');
});