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
    $routes->get('tipo_producto', 'Tipo_producto::index');
    $routes->get('tipo_producto/buscar', 'Tipo_producto::buscar');
    $routes->post('tipo_producto/guardar/(:segment)', 'Tipo_producto::guardar/$1');
    $routes->post('tipo_producto/guardar', 'Tipo_producto::guardar');
    $routes->get('producto', 'Producto::index');
    $routes->get('producto/buscar', 'Producto::buscar');
    $routes->post('producto/guardar/(:segment)', 'Producto::guardar/$1');
    $routes->post('producto/guardar', 'Producto::guardar');
    $routes->get('producto_sucursal/buscar/(:num)', 'Producto_sucursal::buscar/$1');
    $routes->get('producto_sucursal/buscar', 'Producto_sucursal::buscar');
    $routes->post('producto_sucursal/crear', 'Producto_sucursal::create');
    $routes->put('producto_sucursal/actualizar/(:num)', 'Producto_sucursal::update/$1');
    $routes->delete('producto_sucursal/eliminar/(:num)', 'Producto_sucursal::delete/$1');
    //producto_bodega
    $routes->post('producto_bodega/asignar/(:segment)', 'Producto_bodega::asignar_producto_bodega/$1');
    $routes->post('producto_bodega/anular/(:segment)', 'Producto_bodega::anular_producto_bodega/$1');
    $routes->get('producto_bodega/buscar', 'Producto_bodega::buscar');
    //presentacion
    $routes->get('presentacion', 'Presentacion::index');
    $routes->get('presentacion/buscar', 'Presentacion::buscar');
    $routes->post('presentacion/guardar/(:segment)', 'Presentacion::guardar/$1');
    $routes->post('presentacion/guardar', 'Presentacion::guardar');
    //marca
    $routes->get('marca', 'Marca::index');
    $routes->get('marca/buscar', 'Marca::buscar');
    $routes->post('marca/guardar/(:segment)', 'Marca::guardar/$1');
    $routes->post('marca/guardar', 'Marca::guardar');
    //familia
    $routes->get('familia', 'Familia::index');
    $routes->get('familia/buscar', 'Familia::buscar');
    $routes->post('familia/guardar/(:segment)', 'Familia::guardar/$1');
    $routes->post('familia/guardar', 'Familia::guardar');
    //estado
    $routes->get('estado', 'Estado::index');
    $routes->get('estado/buscar', 'Estado::buscar');
    $routes->post('estado/guardar/(:segment)', 'Estado::guardar/$1');
    $routes->post('estado/guardar', 'Estado::guardar');
    //clasificacion
    $routes->get('clasificacion', 'Clasificacion::index');
    $routes->get('clasificacion/buscar', 'Clasificacion::buscar');
    $routes->post('clasificacion/guardar/(:segment)', 'Clasificacion::guardar/$1');
    $routes->post('clasificacion/guardar', 'Clasificacion::guardar');
});
