<?php

namespace App\Models;

use CodeIgniter\Model;

class Catalogo_model extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['campo1', 'campo2']; // Ajustar los campos permitidos

    public function __construct()
    {
        parent::__construct();
    }

    public function ver_empresa_usuario_sucursal($args = [])
    {
        $builder = $this->db->table($this->table);

        if (isset($args['usuario_id'])) {
            $builder->where('u.usuario_id', $args['usuario_id']);
        }

        $builder->select("e.*")
                ->join("sucursal s", "e.id = s.empresa_id")
                ->join("usuario_sucursal u", "u.usuario_id = s.usuario_id");

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_usuario_sucursal($args = [])
    {
        $builder = $this->db->table('usuario_sucursal a');

        if (isset($args['id'])) {
            $builder->where('a.id', $args['id']);
        }

        if (isset($args['usuario_id'])) {
            $builder->where('a.usuario_id', $args['usuario_id']);
        }

        if (isset($args['sucursal_id'])) {
            $builder->where('a.sucursal_id', $args['sucursal_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }

        $builder->select("a.*, b.nombre as nsucursal, b.empresa_id")
                ->join("sucursal b", "b.id = a.sucursal_id");

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_vehiculos_pilotos($args = [])
    {
        $builder = $this->db->table('vehiculos_pilotos vp');

        if (isset($args['id'])) {
            $builder->where('vp.id', $args['id']);
        }

        if (isset($args['pilotos_id'])) {
            $builder->where('vp.pilotos_id', $args['pilotos_id']);
        }

        if (isset($args['vehiculos_id'])) {
            $builder->where('vp.vehiculos_id', $args['vehiculos_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('vp.activo', $args['activo']);
        } else {
            $builder->where('vp.activo', 1);
        }

        $result = $builder->select("vp.*, p.nombre as nombre_piloto, v.nombre as nombre_vehiculo")
                          ->join("pilotos p", "p.id = vp.pilotos_id")
                          ->join("vehiculos v", "v.id = vp.vehiculos_id")
                          ->get();

        return $this->ver_consulta($result, $args);
    }

    public function ver_orden_compra_detalle($args = [])
    {
        $builder = $this->db->table('orden_compra_det ocd');

        if (isset($args['id'])) {
            $builder->where('ocd.id', $args['id']);
        }

        if (isset($args['orden_compra_id'])) {
            $builder->where('ocd.orden_compra_id', $args['orden_compra_id']);
        }

        if (isset($args['producto_id'])) {
            $builder->where('ocd.producto_id', $args['producto_id']);
        }

        if (isset($args['activo'])) {
            $builder->where('ocd.activo', $args['activo']);
        } else {
            $builder->where('ocd.activo', 1);
        }

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_estado_rec($args = [])
    {
        $builder = $this->db->table('estado_recepcion')
                            ->where("activo", 1);

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_tipo_transaccion($args = [])
    {
        $builder = $this->db->table('tipo_transaccion')
                            ->where("activo", 1);

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_vehiculos($args = [])
    {
        $builder = $this->db->table('vehiculos')
                            ->where("activo", 1);

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_pilotos($args = [])
    {
        $builder = $this->db->table('pilotos')
                            ->where("activo", 1);

        $result = $builder->get();
        return $this->ver_consulta($result, $args);
    }

    public function ver_productos_bodega($args = [])
    {
        $builder = $this->db->table('producto_bodega a');

        if (isset($args['bodega'])) {
            $builder->where('a.bodega_id', $args['bodega']);
        }

        $result = $builder->select("1 as cantidad, a.*, a.id as producto_bodega, b.*, b.id as id_producto, 
                                    c.nombre as nombre_bodega, d.nombre as nombre_um, e.nombre as nombre_estado, 
                                    f.nombre as nombre_marca")
                          ->join("producto b", "b.id = a.producto_id")
                          ->join("bodega c", "c.id = a.bodega_id")
                          ->join("unidad_medida d", "d.id = b.unidad_medida_id")
                          ->join("estado_producto e", "e.id = b.estado_producto_id")
                          ->join("marca_producto f", "f.id = b.marca_producto_id")
                          ->where("b.activo", 1)
                          ->get();

        return $this->ver_consulta($result, $args);
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

    private function ver_consulta($result, $args)
    {
        // Implementación de ver_consulta según las necesidades
        return $result->getResultArray();
    }
}

/* End of file Catalogo_model.php */
/* Location: ./application/models/Catalogo_model.php */
