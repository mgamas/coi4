<?php

namespace App\Models;

use function App\Helpers\elemento;
use function App\Helpers\verConsulta;
use CodeIgniter\Model;

class Catalogo_model extends General_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ver_empresa_usuario_sucursal($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('empresa e')
            ->select('e.*')
            ->join('sucursal s', 'e.id = s.empresa_id')
            ->join('usuario_sucursal u', 'u.usuario_id = s.usuario_id');
        //log_message('info','args before elemnto empresa_usario_sucursal: '.$args);
        if (elemento($args, 'usuario_id', [])) {
            $builder->where('u.usuario_id', $args['usuario_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_usuario_sucursal($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario_sucursal a')
            ->select('a.*, b.nombre as nsucursal, b.empresa_id')
            ->join('sucursal b', 'b.id = a.sucursal_id');

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        }

        if (elemento($args, 'usuario_id')) {
            $builder->where('a.usuario_id', $args['usuario_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $builder->where('a.sucursal_id', $args['sucursal_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_vehiculos_pilotos($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('vehiculos_pilotos vp')
            ->select('vp.*, b.*')
            ->join('vehiculos b', 'b.id = vp.vehiculos_id');

        if (elemento($args, 'id')) {
            $builder->where('vp.id', $args['id']);
        }

        if (elemento($args, 'pilotos_id')) {
            $builder->where('vp.pilotos_id', $args['pilotos_id']);
        }

        if (elemento($args, 'vehiculos_id')) {
            $builder->where('vp.vehiculos_id', $args['vehiculos_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('vp.activo', $args['activo']);
        } else {
            $builder->where('vp.activo', 1);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_proveedor_bodega($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_bodega a')
            ->select('a.*, b.nombre as bodega_nombre')
            ->join('bodega b', 'b.id = a.bodega_id');

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        }

        if (elemento($args, 'proveedor_id')) {
            $builder->where('a.proveedor_id', $args['proveedor_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $builder->where('a.bodega_id', $args['bodega_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_producto_bodega($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('producto_bodega a')
            ->select('a.*, b.nombre as bodega_nombre')
            ->join('bodega b', 'b.id = a.bodega_id');

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        }

        if (elemento($args, 'producto_id')) {
            $builder->where('a.producto_id', $args['producto_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $builder->where('a.bodega_id', $args['bodega_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_usuario_rol($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rol_usuario a')
            ->select('a.*, b.nombre as nrol')
            ->join('rol b', 'b.id = a.rol_id');

        if (elemento($args, 'usuario_id')) {
            $builder->where('a.usuario_id', $args['usuario_id']);
        }

        if (elemento($args, 'rol_id')) {
            $builder->where('a.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        }

        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_menu_rol($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('menu_rol mr')
            ->select('mr.*');

        if (elemento($args, 'id')) {
            $builder->where('mr.id', $args['id']);
        }

        if (elemento($args, 'menu_modulo_id')) {
            $builder->where('mr.menu_modulo_id', $args['menu_modulo_id']);
        }

        if (elemento($args, 'rol_id')) {
            $builder->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'activo')) {
            $builder->where('mr.activo', $args['activo']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_modulo_rol($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modulo_rol mr')
            ->select('mr.*');

        if (elemento($args, 'id')) {
            $builder->where('mr.id', $args['id']);
        }

        if (elemento($args, 'modulo_id')) {
            $builder->where('mr.modulo_id', $args['modulo_id']);
        }

        if (elemento($args, 'rol_id')) {
            $builder->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'activo')) {
            $builder->where('mr.activo', $args['activo']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_rol_menu($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('menu_modulo mm')
            ->select('mm.*, mr.id as menu_rol_id')
            ->join('menu_rol mr', 'mm.id = mr.menu_modulo_id')
            ->join('rol b', 'b.id = mr.rol_id')
            ->where('mr.activo', 1);

        if (elemento($args, 'rol_id')) {
            $builder->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'menu_modulo_id')) {
            $builder->where('mm.id', $args['menu_modulo_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_rol_modulo($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modulo m')
            ->select('m.*, mr.id as modulo_rol_id')
            ->join('modulo_rol mr', 'm.id = mr.modulo_id')
            ->join('rol b', 'b.id = mr.rol_id')
            ->where('mr.activo', 1);

        if (elemento($args, 'rol_id')) {
            $builder->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'modulo_id')) {
            $builder->where('m.id', $args['modulo_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_sucursal($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('sucursal')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_empleado($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('empleado')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_usuario($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('usuario')
            ->select('*')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_proveedor($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('proveedor')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_rol($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('rol')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_um($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('unidad_medida')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_marca($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('marca_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_clasificacion($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('clasificacion_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_estado($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('estado_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_tipo($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('tipo_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_familia($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('familia_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_presentacion($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('presentacion_producto')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_empresa()
    {
        $empresaModel = new \App\Models\mnt\Empresa_model();
        return $empresaModel->buscar();
    }

    public function ver_menu($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('menu')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_menu_modulo($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('menu_modulo')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_menu_modulo_filter($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modulo m')
            ->select('mm.*')
            ->join('modulo_rol mr', 'm.id = mr.modulo_id')
            ->join('menu_modulo mm', 'm.id = mm.modulo_id')
            ->where('mr.activo', 1);

        if (elemento($args, 'rol_id')) {
            $builder->where('mr.rol_id', $args['rol_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_modulo($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('modulo')
            ->where('titulo', 0)
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_motivo_anulacion_pedido($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('motivo_anulacion_pedido')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_motivo_devolucion($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('motivo_devolucion')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_pedido_tipo($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedido_tipo');

        if (elemento($args, 'nombre')) {
            $builder->where('nombre', $args['nombre']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_cliente_tipo()
    {
        $clienteTipoModel = new \App\Models\mnt\Cliente_tipo_model();
        return $clienteTipoModel->buscar();
    }

    public function ver_cliente($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('cliente')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_cliente_bodega($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente_bodega cb')
            ->select('cb.*, b.nombre as nombre_bodega')
            ->join('bodega b', 'b.id = cb.bodega_id');

        if (elemento($args, 'id')) {
            $builder->where('cb.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $builder->where('cb.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $builder->where('cb.bodega_id', $args['bodega_id']);
        }

        $builder->where('cb.activo', $args['activo'] ?? 1);

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_cliente_sucursal($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente_sucursal cs')
            ->select('cs.*, b.nombre as nombre_sucursal')
            ->join('sucursal b', 'b.id = cs.sucursal_id');

        if (elemento($args, 'id')) {
            $builder->where('cs.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $builder->where('cs.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $builder->where('cs.sucursal_id', $args['sucursal_id']);
        }

        $builder->where('cs.activo', $args['activo'] ?? 1);

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_empleado_sucursal($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('empleado_sucursal es')
            ->select('es.*, b.nombre as nombre_sucursal')
            ->join('sucursal b', 'b.id = es.sucursal_id');

        if (elemento($args, 'id')) {
            $builder->where('es.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $builder->where('es.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $builder->where('es.sucursal_id', $args['sucursal_id']);
        }

        $builder->where('es.activo', $args['activo'] ?? 1);

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_rotacion($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('rotacion')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_proveedor_bodega_orden($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('proveedor_bodega pb')
            ->select('pb.*, p.nombre as nombre_proveedor, b.nombre as nombre_bodega')
            ->join('proveedor p', 'p.id = pb.proveedor_id')
            ->join('bodega b', 'b.id = pb.bodega_id')
            ->where('pb.activo', 1);

        if (isset($args['bodega_id'])) {
            $builder->where('b.id', $args['bodega_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_producto_bodega_orden($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('producto_bodega pb')
            ->select('pb.*, p.codigo as codigo_producto, p.nombre as nombre_producto, b.nombre as nombre_bodega')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('bodega b', 'b.id = pb.bodega_id')
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_bodega($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('bodega')
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_ruta($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('ruta')
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_producto($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('producto pr');

        if (elemento($args, 'id')) {
            $builder->where('pr.id', $args['id']);
        }

        if (elemento($args, 'codigo')) {
            $builder->where('pr.codigo', $args['codigo']);
        }

        if (elemento($args, 'nombre')) {
            $builder->where('pr.nombre', $args['nombre']);
        }

        $builder->where('pr.activo', $args['activo'] ?? 1);

        $query = $builder->get();
        return verConsulta($query, $args);
    }


    public function ver_orden_compra_tipo($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('orden_compra_tipo')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_orden_compra_estado($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('orden_compra_estado')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_orden_compra_det($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orden_compra_det ocd')
            ->select('ocd.*, p.id as id_producto_j, p.codigo as codigo_producto_j, p.nombre as nombre_producto_j, pp.codigo as codigo_presentacion_j, pp.nombre nombre_presentacion_j, um.nombre as nombre_unidad_medida_j, md.nombre as nombre_motivo_dev')
            ->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id')
            ->join('unidad_medida um', 'um.id = ocd.unidad_medida_id')
            ->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id')
            ->where('ocd.activo', 1);

        if (elemento($args, 'orden_compra_enc_id')) {
            $builder->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_estado_rec($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('estado_recepcion')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_tipo_transaccion($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('tipo_transaccion')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_vehiculos($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('vehiculos')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_pilotos($args = [])
    {
        $db = \Config\Database::connect();
        $query = $db->table('pilotos')
            ->where('activo', 1)
            ->get();

        return verConsulta($query, $args);
    }

    public function ver_productos_bodega($args = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('producto_bodega a')
            ->select('
                    1 as cantidad,
                    a.*, 
                    a.id as producto_bodega, 
                    b.*,
                    b.id as id_producto,
                    c.nombre as nombre_bodega,
                    d.nombre as nombre_um,
                    e.nombre as nombre_estado,
                    f.nombre as nombre_marca')
            ->join('producto b', 'b.id = a.producto_id')
            ->join('bodega c', 'c.id = a.bodega_id')
            ->join('unidad_medida d', 'd.id = b.unidad_medida_id')
            ->join('estado_producto e', 'e.id = b.estado_producto_id')
            ->join('marca_producto f', 'f.id = b.marca_producto_id')
            ->where('b.activo', 1);

        if (elemento($args, 'bodega')) {
            $builder->where('a.bodega_id', $args['bodega']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }

    public function ver_productos()
    {
        $productoModel = new \App\Models\producto\Producto_model();
        return $productoModel->buscar();
    }

    public function ver_ubicacion($args = [])
    {
        $ubicacionModel = new \App\Models\bodega\Ubicacion_model();
        return $ubicacionModel->_buscar($args);
    }


    // Métodos adicionales como verConsulta y elemento deben estar definidos en General_model o en este modelo si no están heredados.
}
