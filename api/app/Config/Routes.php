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


$routes->group('pedido', ['namespace' => 'App\Controllers\pedido'], function($routes) {
    $routes->get('detalle', 'Detalle::index');
    $routes->get('detalle/buscar', 'Detalle::buscar');
    $routes->post('detalle/guardar/(:segment)', 'Detalle::guardar/$1');
    $routes->post('detalle/guardar', 'Detalle::guardar');
    $routes->delete('detalle/eliminar_producto/(:segment)', 'Detalle::eliminar_producto/$1');
    $routes->get('principal', 'Principal::index');
    $routes->get('principal/buscar', 'Principal::buscar');
    $routes->get('principal/get_datos', 'Principal::get_datos');
    $routes->post('principal/guardar/(:any)', 'Principal::guardar/$1');
    $routes->post('principal/guardar', 'Principal::guardar');
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

$routes->group('orden', ['namespace' => 'App\Controllers\orden'], function($routes) {
    $routes->get('ordencompra', 'OrdenCompra::index');
    $routes->get('ordencompra/buscar', 'OrdenCompra::buscar');
    $routes->post('ordencompra/guardar/(:segment)', 'OrdenCompra::guardar/$1');
    $routes->post('ordencompra/guardar', 'OrdenCompra::guardar');
    $routes->get('ordencompradetalle', 'OrdenCompraDetalle::index');
    $routes->get('ordencompradetalle/buscar', 'OrdenCompraDetalle::buscar');
    $routes->get('ordencompradetalle/getLast', 'OrdenCompraDetalle::getLast');
    $routes->post('ordencompradetalle/guardar/(:segment)', 'OrdenCompraDetalle::guardar/$1');
    $routes->post('ordencompradetalle/guardar', 'OrdenCompraDetalle::guardar');
    $routes->post('ordencompradetalle/eliminar_producto/(:segment)', 'OrdenCompraDetalle::eliminar_producto/$1');
    $routes->post('ordencompradetalle/actualizar_linea/(:segment)', 'OrdenCompraDetalle::actualizar_linea/$1');
});

$routes->group('app/mnt', ['namespace' => 'App\Controllers\mnt'], function($routes) {
    $routes->get('cliente_bodega', 'Cliente_bodega::index');
    $routes->post('cliente_bodega/asignar_cliente_bodega/(:segment)', 'Cliente_bodega::asignar_cliente_bodega/$1');
    $routes->post('cliente_bodega/anular_cliente_bodega/(:segment)', 'Cliente_bodega::anular_cliente_bodega/$1');
    //cliente contacto
    $routes->get('cliente_contacto', 'Cliente_contacto::index');
    $routes->get('cliente_contacto/buscar', 'Cliente_contacto::buscar');
    $routes->post('cliente_contacto/guardar/(:any)', 'Cliente_contacto::guardar/$1');
    $routes->post('cliente_contacto/guardar', 'Cliente_contacto::guardar');
    //cliente_direccion_rutas
    $routes->get('cliente_direccion', 'Cliente_direccion::index');
    $routes->get('cliente_direccion/buscar', 'Cliente_direccion::buscar');
    $routes->post('cliente_direccion/guardar/(:segment)', 'Cliente_direccion::guardar/$1');
    $routes->post('cliente_direccion/guardar', 'Cliente_direccion::guardar');
    //cliente_sucursal_rutas
    $routes->get('cliente_sucursal', 'Cliente_sucursal::index');
    $routes->post('cliente_sucursal/asignar_cliente_sucursal/(:any)', 'Cliente_sucursal::asignar_cliente_sucursal/$1');
    $routes->post('cliente_sucursal/anular_cliente_sucursal/(:any)', 'Cliente_sucursal::anular_cliente_sucursal/$1');
    $routes->get('cliente_sucursal/buscar', 'Cliente_sucursal::buscar');

    //Cliente_tipo_rutas
    $routes->get('cliente_tipo', 'Cliente_tipo::index');
    $routes->get('cliente_tipo/buscar', 'Cliente_tipo::buscar');
    $routes->post('cliente_tipo/guardar/(:any)', 'Cliente_tipo::guardar/$1');
    $routes->get('cliente-tipo/buscar', 'Cliente_tipo::buscar');
    //Clientes_rutas
    $routes->get('cliente', 'cliente::index');
    $routes->post('cliente/guardar/(:any)', 'cliente::guardar/$1');
    $routes->post('cliente/anular_cliente/(:any)', 'cliente::anular_cliente/$1');
    $routes->get('cliente/buscar', 'cliente::buscar');
    //Empleado_sucursal
    $routes->get('empleado_sucursal', 'Empleado_sucursal::index');
    $routes->post('empleado_sucursal/asignar_empleado_sucursal/(:any)', 'Empleado_sucursal::asignar_empleado_sucursal/$1');
    $routes->post('empleado_sucursal/anular_empleado_sucursal/(:any)', 'Empleado_sucursal::anular_empleado_sucursal/$1');
    $routes->get('empleado_sucursal/buscar', 'Empleado_sucursal::buscar');
    //Empleado
    $routes->get('empleado', 'Empleado::index');
    $routes->get('empleado/buscar', 'Empleado::buscar');
    $routes->post('empleado/guardar/(:any)', 'Empleado::guardar/$1');
    $routes->post('empleado/anular_empleado/(:any)', 'Empleado::anular_empleado/$1');
    //Empresa
    $routes->get('empresa', 'Empresa::index');
    $routes->get('empresa/buscar', 'Empresa::buscar');
    $routes->post('empresa/guardar/(:any)', 'Empresa::guardar/$1');
    //Menu_rol
    $routes->get('menu_rol', 'Menu_rol::index');
    $routes->post('menu_rol/asignar_menu/(:any)', 'Menu_rol::asignar_menu/$1');
    $routes->post('menu_rol/anular_menu_rol/(:any)', 'Menu_rol::anular_menu_rol/$1');
    $routes->get('menu_rol/buscar', 'Menu_rol::buscar');

    //Menu
    $routes->get('menu', 'Menu::index');
    $routes->get('menu/buscar', 'Menu::buscar');
    $routes->get('menu/get_modulos', 'Menu::get_modulos');
    $routes->get('menu/get_opciones', 'Menu::get_opciones');
    $routes->post('menu/guardar/(:any)', 'Menu::guardar/$1');
    $routes->post('menu/guardar_opcion/(:any)', 'Menu::guardar_opcion/$1');
    $routes->post('menu/anular_modulo/(:any)', 'Menu::anular_modulo/$1');
    $routes->post('menu/anular_opcion/(:any)', 'Menu::anular_opcion/$1');
    //Modulo_rol
    $routes->get('modulo_rol', 'Modulo_rol::index');
    $routes->post('modulo_rol/asignar_modulo/(:any)', 'Modulo_rol::asignar_modulo/$1');
    $routes->post('modulo_rol/anular_modulo_rol/(:any)', 'Modulo_rol::anular_modulo_rol/$1');
    $routes->get('modulo_rol/buscar', 'Modulo_rol::buscar');

    //Motivo_anulacion_pedido
    $routes->get('motivo_anulacion_pedido', 'Motivo_anulacion_pedido::index');
    $routes->get('motivo_anulacion_pedido/buscar', 'Motivo_anulacion_pedido::buscar');
    $routes->post('motivo_anulacion_pedido/guardar/(:any)', 'Motivo_anulacion_pedido::guardar/$1');
    //Motivo_devolucion
    $routes->get('motivo_devolucion', 'Motivo_devolucion::index');
    $routes->get('motivo_devolucion/buscar', 'Motivo_devolucion::buscar');
    $routes->post('motivo_devolucion/guardar/(:any)', 'Motivo_devolucion::guardar/$1');
    //pedido_tipo
    $routes->get('pedido_tipo', 'Pedido_tipo::index');
    $routes->get('pedido_tipo/buscar', 'Pedido_tipo::buscar');
    $routes->post('pedido_tipo/guardar/(:any)', 'Pedido_tipo::guardar/$1');
    //Pilotos
    $routes->get('pilotos', 'Pilotos::index');
    $routes->get('pilotos/buscar', 'Pilotos::buscar');
    $routes->post('pilotos/guardar/(:any)', 'Pilotos::guardar/$1');
    //Proveedores_bodega
    $routes->get('proveedor_bodega', 'Proveedor_bodega::index');
    $routes->post('proveedor_bodega/asignar_proveedor_bodega/(:any)', 'Proveedor_bodega::asignar_proveedor_bodega/$1');
    $routes->post('proveedor_bodega/anular_proveedor_bodega/(:any)', 'Proveedor_bodega::anular_proveedor_bodega/$1');
    $routes->get('proveedor_bodega/buscar', 'proveedor_bodega::buscar');
    //Proveedores
    $routes->get('proveedor', 'Proveedor::index');
    $routes->get('proveedor/buscar', 'Proveedor::buscar');
    $routes->post('proveedor/guardar/(:any)', 'Proveedor::guardar/$1');
    //Rol_usuario
    $routes->get('rol_usuario', 'Rol_usuario::index');
    $routes->post('rol_usuario/asignar_rol/(:any)', 'Rol_usuario::asignar_rol/$1');
    $routes->post('rol_usuario/anular_rol_usuario/(:any)', 'Rol_usuario::anular_rol_usuario/$1');
    $routes->get('rol_usuario/buscar', 'rol_usuario::buscar');


    //Rol
    $routes->get('rol', 'Rol::index');
    $routes->get('rol/buscar', 'Rol::buscar');
    $routes->post('rol/guardar/(:any)', 'Rol::guardar/$1');
    $routes->post('rol/anular_rol/(:any)', 'Rol::anular_rol/$1');
    //Ruta
    $routes->get('ruta', 'Ruta::index');
    $routes->get('ruta/buscar', 'Ruta::buscar');
    $routes->post('ruta/guardar/(:any)', 'Ruta::guardar/$1');
    //Sucursal
    $routes->get('sucursal', 'Sucursal::index');
    $routes->get('sucursal/buscar', 'Sucursal::buscar');
    $routes->post('sucursal/guardar/(:any)', 'Sucursal::guardar/$1');
    //Tipo_transaccion
    $routes->get('tipo_transaccion', 'Tipo_transaccion::index');
    $routes->get('tipo_transaccion/buscar', 'Tipo_transaccion::buscar');
    $routes->post('tipo_transaccion/guardar/(:any)', 'Tipo_transaccion::guardar/$1');
    $routes->post('tipo_transaccion/guardar', 'Tipo_transaccion::guardar');
    //Usuario_sucursal
    $routes->get('usuario_sucursal', 'Usuario_sucursal::index');
    $routes->post('usuario_sucursal/asignar_sucursal/(:any)', 'Usuario_sucursal::asignar_sucursal/$1');
    $routes->post('usuario_sucursal/asignar_sucursal', 'Usuario_sucursal::asignar_sucursal');
    $routes->post('usuario_sucursal/anular_sucursal/(:any)', 'Usuario_sucursal::anular_sucursal/$1');
    $routes->get('usuario_sucursal/buscar', 'Usuario_sucursal::buscar');

    //Vehiculos_pilotos
    $routes->get('vehiculos_pilotos', 'Vehiculos_pilotos::index');
    $routes->post('vehiculos_pilotos/asignar_vehiculos_pilotos/(:any)', 'Vehiculos_pilotos::asignar_Vehiculos_Pilotos/$1');
    $routes->post('vehiculos_pilotos/asignar_vehiculos_pilotos', 'Vehiculos_pilotos::asignar_Vehiculos_Pilotos');
    $routes->post('vehiculos_pilotos/anular_vehiculos_pilotos/(:any)', 'Vehiculos_pilotos::anular_vehiculos_pilotos/$1');
    $routes->get('vehiculos_pilotos/buscar' , 'Vehiculos_pilotos::buscar');

    //Vehiculos
    $routes->get('vehiculos', 'Vehiculos::index');
    $routes->get('vehiculos/buscar', 'Vehiculos::buscar');
    $routes->post('vehiculos/guardar/(:any)', 'Vehiculos::guardar/$1');
    $routes->post('vehiculos/guardar', 'Vehiculos::guardar');


});

$routes->group('bodega', ['namespace' => 'App\Controllers\bodega'], function($routes) {
    $routes->get('area', 'Area::index');
    $routes->get('area/buscar', 'Area::buscar');
    $routes->post('area/guardar/(:segment)', 'Area::guardar/$1');
    $routes->post('area/guardar', 'Area::guardar');
    //bodega
    $routes->get('bodega/index', 'Bodega::index');
    $routes->get('bodega/get_datos', 'Bodega::get_datos');
    $routes->get('bodega/buscar', 'Bodega::buscar');
    $routes->post('bodega/guardar/(:segment)', 'Bodega::guardar/$1');
    $routes->post('bodega/guardar', 'Bodega::guardar');
    //sector
    $routes->get('sector/index', 'Sector::index');
    $routes->get('sector/buscar', 'Sector::buscar');
    $routes->post('sector/guardar/(:segment)', 'Sector::guardar/$1');
    $routes->post('sector/guardar', 'Sector::guardar');
    //tramo
    $routes->get('tramo/index', 'Tramo::index');
    $routes->get('tramo/buscar', 'Tramo::buscar');
    $routes->post('tramo/guardar/(:segment)', 'Tramo::guardar/$1');
    $routes->post('tramo/guardar', 'Tramo::guardar');
    //ubicacion
    $routes->get('ubicacion/index', 'Ubicacion::index');
    $routes->get('ubicacion/buscar', 'Ubicacion::buscar');
    $routes->post('ubicacion/guardar/(:segment)', 'Ubicacion::guardar/$1');
    $routes->post('ubicacion/guardar', 'Ubicacion::guardar');
});

$routes->group('despacho', ['namespace' => 'App\Controllers\despacho'], function($routes) {
    $routes->get('detalle', 'Detalle::index');
    $routes->get('detalle/buscar', 'Detalle::buscar');
    $routes->post('detalle/guardar/(:segment)', 'Detalle::guardar/$1');
    $routes->post('detalle/guardar_detalle', 'Detalle::guardar_detalle');
    $routes->delete('detalle/eliminar_producto/(:segment)', 'Detalle::eliminar_producto/$1');
    //principal
    $routes->get('principal', 'Principal::index');
    $routes->get('principal/buscar', 'Principal::buscar');
    $routes->get('principal/get_datos', 'Principal::get_datos');
    $routes->post('principal/guardar/(:segment)', 'Principal::guardar/$1');
    $routes->post('principal/despachar', 'Principal::despachar');
});

