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
        if (elemento($args, 'usuario_id')) {
            $this->where('u.usuario_id', $args['usuario_id']);
        }

        $query = $this->select('e.*')
            ->join('sucursal s', 'e.id = s.empresa_id')
            ->join('usuario_sucursal u', 'u.usuario_id = s.usuario_id')
            ->get('empresa e');

        return verConsulta($query, $args);
    }

    public function ver_usuario_sucursal($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('a.id', $args['id']);
        }

        if (elemento($args, 'usuario_id')) {
            $this->where('a.usuario_id', $args['usuario_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $this->where('a.sucursal_id', $args['sucursal_id']);
        }

        if (isset($args['activo'])) {
            $this->where('a.activo', $args['activo']);
        } else {
            $this->where('a.activo', 1);
        }

        $query = $this->select('a.*, b.nombre as nsucursal, b.empresa_id')
            ->join('sucursal b', 'b.id = a.sucursal_id')
            ->get('usuario_sucursal a');

        return verConsulta($query, $args);
    }

    public function ver_vehiculos_pilotos($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('vp.id', $args['id']);
        }

        if (elemento($args, 'pilotos_id')) {
            $this->where('vp.pilotos_id', $args['pilotos_id']);
        }

        if (elemento($args, 'vehiculos_id')) {
            $this->where('vp.vehiculos_id', $args['vehiculos_id']);
        }

        if (isset($args['activo'])) {
            $this->where('vp.activo', $args['activo']);
        } else {
            $this->where('vp.activo', 1);
        }

        $query = $this->select('vp.*, b.*')
            ->join('vehiculos b', 'b.id = vp.vehiculos_id')
            ->get('vehiculos_pilotos vp');

        return verConsulta($query, $args);
    }

    public function ver_proveedor_bodega($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('a.id', $args['id']);
        }

        if (elemento($args, 'proveedor_id')) {
            $this->where('a.proveedor_id', $args['proveedor_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $this->where('a.bodega_id', $args['bodega_id']);
        }

        if (isset($args['activo'])) {
            $this->where('a.activo', $args['activo']);
        } else {
            $this->where('a.activo', 1);
        }

        $query = $this->select('a.*, b.nombre as bodega_nombre')
            ->join('bodega b', 'b.id = a.bodega_id')
            ->get('proveedor_bodega a');

        return verConsulta($query, $args);
    }

    public function ver_producto_bodega($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('a.id', $args['id']);
        }

        if (elemento($args, 'producto_id')) {
            $this->where('a.producto_id', $args['producto_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $this->where('a.bodega_id', $args['bodega_id']);
        }

        if (isset($args['activo'])) {
            $this->where('a.activo', $args['activo']);
        } else {
            $this->where('a.activo', 1);
        }

        $query = $this->select('a.*, b.nombre as bodega_nombre')
            ->join('bodega b', 'b.id = a.bodega_id')
            ->get('producto_bodega a');

        return verConsulta($query, $args);
    }

    public function ver_usuario_rol($args = [])
    {
        if (elemento($args, 'usuario_id')) {
            $this->where('a.usuario_id', $args['usuario_id']);
        }

        if (elemento($args, 'rol_id')) {
            $this->where('a.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'id')) {
            $this->where('a.id', $args['id']);
        }

        if (isset($args['activo'])) {
            $this->where('a.activo', $args['activo']);
        } else {
            $this->where('a.activo', 1);
        }

        $query = $this->select('a.*, b.nombre as nrol')
            ->join('rol b', 'b.id = a.rol_id')
            ->get('rol_usuario a');

        return verConsulta($query, $args);
    }

    public function ver_menu_rol($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('mr.id', $args['id']);
        }

        if (elemento($args, 'menu_modulo_id')) {
            $this->where('mr.menu_modulo_id', $args['menu_modulo_id']);
        }

        if (elemento($args, 'rol_id')) {
            $this->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'activo')) {
            $this->where('mr.activo', $args['activo']);
        }

        $query = $this->select('mr.*')
            ->get('menu_rol mr');

        return verConsulta($query, $args);
    }

    public function ver_modulo_rol($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('mr.id', $args['id']);
        }

        if (elemento($args, 'modulo_id')) {
            $this->where('mr.modulo_id', $args['modulo_id']);
        }

        if (elemento($args, 'rol_id')) {
            $this->where('mr.rol_id', $args['rol_id']);
        }

        if (elemento($args, 'activo')) {
            $this->where('mr.activo', $args['activo']);
        }

        $query = $this->select('mr.*')
            ->get('modulo_rol mr');

        return verConsulta($query, $args);
    }

    public function ver_rol_menu($args = [])
    {
        if (elemento($args, 'rol_id')) {
            $this->where('mr.rol_id', $args['rol_id']);
        }
        
        if (elemento($args, 'menu_modulo_id')) {
            $this->where('mm.id', $args['menu_modulo_id']);
        }

        $query = $this->select('mm.*, mr.id as menu_rol_id')
            ->join('menu_rol mr', 'mm.id = mr.menu_modulo_id')
            ->join('rol b', 'b.id = mr.rol_id')
            ->where('mr.activo', 1)
            ->get('menu_modulo mm');
                    
        return verConsulta($query, $args);
    }

    public function ver_rol_modulo($args = [])
    {
        if (elemento($args, 'rol_id')) {
            $this->where('mr.rol_id', $args['rol_id']);
        }
        
        if (elemento($args, 'modulo_id')) {
            $this->where('m.id', $args['modulo_id']);
        }

        $query = $this->select('m.*, mr.id as modulo_rol_id')
            ->join('modulo_rol mr', 'm.id = mr.modulo_id')
            ->join('rol b', 'b.id = mr.rol_id')
            ->where('mr.activo', 1)
            ->get('modulo m');
                    
        return verConsulta($query, $args);
    }

    public function ver_sucursal($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('sucursal');

        return verConsulta($query, $args);
    }
    
    public function ver_empleado($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('empleado');

        return verConsulta($query, $args);
    }

    public function ver_usuario($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('usuario');

        return verConsulta($query, $args);
    }

    public function ver_proveedor($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('proveedor');

        return verConsulta($query, $args);
    }

    public function ver_rol($args = [])
    {   
        $query = $this->where('activo', 1)
            ->get('rol');

        return verConsulta($query, $args);
    }

    public function ver_um($args = [])
    {   
        $query = $this->where('activo', 1)
            ->get('unidad_medida');

        return verConsulta($query, $args);
    }
    
    public function ver_marca($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('marca_producto');

        return verConsulta($query, $args);
    }

    public function ver_clasificacion($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('clasificacion_producto');

        return verConsulta($query, $args);
    }

    public function ver_estado($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('estado_producto');

        return verConsulta($query, $args);
    }

    public function ver_tipo($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('tipo_producto');

        return verConsulta($query, $args);
    }

    public function ver_familia($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('familia_producto');

        return verConsulta($query, $args);
    }

    public function ver_presentacion($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('presentacion_producto');

        return verConsulta($query, $args);
    }

    public function ver_empresa()
    {
        // En CodeIgniter 4, utilizamos namespaces para cargar otros modelos
        $empresaModel = new \App\Models\Empresa_model();
        return $empresaModel->buscar();
    }

    public function ver_menu($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('menu');

        return verConsulta($query, $args);
    }

    public function ver_menu_modulo($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('menu_modulo');

        return verConsulta($query, $args);
    }

    public function ver_menu_modulo_filter($args = [])
    {
        if (elemento($args, 'rol_id')) {
            $this->where('mr.rol_id', $args['rol_id']);
        }

        $this->where('mr.activo', 1);
        
        $query = $this->select('mm.*')
            ->join('modulo_rol mr', 'm.id = mr.modulo_id')
            ->join('menu_modulo mm', 'm.id = mm.modulo_id')
            ->get('modulo m');

        return verConsulta($query, $args);
    }

    public function ver_modulo($args = [])
    {
        $query = $this->where('titulo', 0)
            ->where('activo', 1)
            ->get('modulo');

        return verConsulta($query, $args);
    }

    public function ver_motivo_anulacion_pedido($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('motivo_anulacion_pedido');

        return verConsulta($query, $args);
    }

    public function ver_motivo_devolucion($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('motivo_devolucion');

        return verConsulta($query, $args);
    }

    public function ver_pedido_tipo($args = [])
    {
        if (elemento($args, 'nombre')) {
            $this->where('nombre', $args['nombre']);
        }

        $query = $this->get('pedido_tipo');

        return verConsulta($query, $args);
    }

    public function ver_cliente_tipo()
    {
        // En CodeIgniter 4, utilizamos namespaces para cargar otros modelos
        $clienteTipoModel = new \App\Models\Cliente_tipo_model();
        return $clienteTipoModel->buscar();
    }

    public function ver_cliente($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('cliente');

        return verConsulta($query, $args);
    }

    public function ver_cliente_bodega($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('cb.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $this->where('cb.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'bodega_id')) {
            $this->where('cb.bodega_id', $args['bodega_id']);
        }

        $this->where('cb.activo', $args['activo'] ?? 1);

        $query = $this->select('cb.*, b.nombre as nombre_bodega')
            ->join('bodega b', 'b.id = cb.bodega_id')
            ->get('cliente_bodega cb');

        return verConsulta($query, $args);
    }

    public function ver_cliente_sucursal($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('cs.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $this->where('cs.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $this->where('cs.sucursal_id', $args['sucursal_id']);
        }

        $this->where('cs.activo', $args['activo'] ?? 1);

        $query = $this->select('cs.*, b.nombre as nombre_sucursal')
            ->join('sucursal b', 'b.id = cs.sucursal_id')
            ->get('cliente_sucursal cs');

        return verConsulta($query, $args);
    }

    public function ver_empleado_sucursal($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('es.id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $this->where('es.cliente_id', $args['cliente_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $this->where('es.sucursal_id', $args['sucursal_id']);
        }

        $this->where('es.activo', $args['activo'] ?? 1);

        $query = $this->select('es.*, b.nombre as nombre_sucursal')
            ->join('sucursal b', 'b.id = es.sucursal_id')
            ->get('empleado_sucursal es');

        return verConsulta($query, $args);
    }

    public function ver_rotacion($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('rotacion');

        return verConsulta($query, $args);
    }

    public function ver_proveedor_bodega_orden($args = [])
    {
        if (isset($args['bodega_id'])) {
            $this->where('b.id', $args['bodega_id']);
        }

        $query = $this->select('pb.*, p.nombre as nombre_proveedor, b.nombre as nombre_bodega')
            ->join('proveedor p', 'p.id = pb.proveedor_id')
            ->join('bodega b', 'b.id = pb.bodega_id')
            ->where('pb.activo', 1)
            ->get('proveedor_bodega pb');

        return verConsulta($query, $args);
    }

    public function ver_producto_bodega_orden($args = [])
    {
        $query = $this->select('pb.*, p.codigo as codigo_producto, p.nombre as nombre_producto, b.nombre as nombre_bodega')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('bodega b', 'b.id = pb.bodega_id')
            ->get('producto_bodega pb');

        return verConsulta($query, $args);
    }

    public function ver_bodega($args = [])
    {
        $query = $this->get('bodega');

        return verConsulta($query, $args);
    }

    public function ver_ruta($args = [])
    {
        $query = $this->get('ruta');

        return verConsulta($query, $args);
    }

    public function ver_producto($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('pr.id', $args['id']);
        }

        if (elemento($args, 'codigo')) {
            $this->where('pr.codigo', $args['codigo']);
        }

        if (elemento($args, 'nombre')) {
            $this->where('pr.nombre', $args['nombre']);
        }

        $this->where('pr.activo', $args['activo'] ?? 1);

        $query = $this->get('producto pr');

        return verConsulta($query, $args);
    }

    public function ver_orden_compra_tipo($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('orden_compra_tipo');

        return verConsulta($query, $args);
    }

    public function ver_orden_compra_estado($args = [])
    {
        $query = $this->where('activo', 1)
            ->get('orden_compra_estado');

        return verConsulta($query, $args);
    }

    public function ver_orden_compra_det($args = [])
    {
        if (elemento($args, 'orden_compra_enc_id')) {
            $this->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
        }

        $query = $this->select('ocd.*, p.id as id_producto_j, p.codigo as codigo_producto_j, p.nombre as nombre_producto_j, pp.codigo as codigo_presentacion_j, pp.nombre nombre_presentacion_j, um.nombre as nombre_unidad_medida_j, md.nombre as nombre_motivo_dev')
            ->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id')
            ->join('unidad_medida um', 'um.id = ocd.unidad_medida_id')
            ->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id')
            ->where('ocd.activo', 1)
            ->get('orden_compra_det ocd');

        return verConsulta($query, $args);
    }

    public function ver_estado_rec($args = [])
    {
        $query = $this->where("activo", 1)
            ->get("estado_recepcion");

        return verConsulta($query, $args);
    }

    public function ver_tipo_transaccion($args = [])
    {
        $query = $this->where("activo", 1)
            ->get("tipo_transaccion");

        return verConsulta($query, $args);
    }

    public function ver_vehiculos($args = [])
    {
        $query = $this->where("activo", 1)
            ->get("vehiculos");

        return verConsulta($query, $args);
    }

    public function ver_pilotos($args = [])
    {
        $query = $this->where("activo", 1)
            ->get("pilotos");

        return verConsulta($query, $args);
    }

    public function ver_productos_bodega($args = [])
    {
        if (elemento($args, 'bodega')) {
            $this->where('a.bodega_id', $args['bodega']);
        }

        $query = $this->select('
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
            ->where("b.activo", 1)
            ->get("producto_bodega a");

        return verConsulta($query, $args);
    }

    public function ver_productos()
    {
        $productoModel = new \App\Models\Producto_model();
        return $productoModel->buscar();
    }

    public function ver_ubicacion($args = [])
    {
        $ubicacionModel = new \App\Models\Ubicacion_model();
        return $ubicacionModel->_buscar($args);
    }

    // Métodos adicionales como verConsulta y elemento deben estar definidos en General_model o en este modelo si no están heredados.
}
