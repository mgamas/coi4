<?php

namespace App\Models\Stock;

use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;
use App\Models\General_model;

class Stock_model extends General_model
{
    protected $table = 'stock_bodega';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'lote', 'fecha_vence', 'cantidad', 'peso', 'fecha_ingreso', 'activo', 
        'producto_bodega_id', 'bodega_id', 'estado_producto_id', 
        'presentacion_producto_id', 'unidad_medida_id', 'bodega_ubicacion_id', 
        'bodega_ubicacion_id_anterior', 'recepcion_enc_id', 'recepcion_det_id', 
        'pedido_enc_id', 'pedido_det_id', 'despacho_enc_id'
    ];

    public $lote = null;
    public $fecha_vence = null;
    public $cantidad = null;
    public $peso = null;
    public $fecha_ingreso = null;
    public $activo = 1;
    public $producto_bodega_id;
    public $bodega_id;
    public $estado_producto_id;
    public $presentacion_producto_id = null;
    public $unidad_medida_id;
    public $bodega_ubicacion_id;
    public $bodega_ubicacion_id_anterior;
    public $recepcion_enc_id = null;
    public $recepcion_det_id = null;
    public $pedido_enc_id = null;
    public $pedido_det_id = null;
    public $despacho_enc_id = null;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla("stock_bodega");
        $this->setLlave("id");

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = '')
    {
        $builder = $this->db->table("$this->table a");

        if (elemento($args, 'id')) {
            $builder->where("a.id", $args['id']);
        } else {
            if (elemento($args, 'recepcion_enc_id')) {
                $builder->where("a.recepcion_enc_id", $args['recepcion_enc_id']);
            }
        }

        $builder->select("a.*, c.id as id_producto, c.control_vence")
                ->join("producto_bodega b", "b.id = a.producto_bodega_id")
                ->join("producto c", "c.id = b.producto_id")
                ->where("a.activo", 1)
                ->orderBy("a.no_linea");

        $tmp = $builder->get();

        return verConsulta($tmp, $args);
    }

    public function ObtenerStock($args = '')
    {
        $builder = $this->db->table("$this->table a");

        if (elemento($args, 'bodega_id')) {
            $builder->where("g.id", $args['bodega_id']);
        }

        if (elemento($args, 'criterio')) {
            $termino = trim($args['criterio']);
            $campos = [
                'g.codigo',
                'g.nombre',
                'a.lote',
                'c.codigo',
                'c.nombre'
            ];
            $where = implode(" like '%{$termino}%' or ", $campos);
            $builder->where("({$where} like '%{$termino}%')", null, false);
        }

        $builder->select("a.id as stock_id
                , a.lote
                , a.fecha_vence
                , a.cantidad - IFNULL(i.cantidad, 0) cantidad_stock
                , a.fecha_ingreso
                , a.producto_bodega_id
                , a.estado_producto_id
                , g.id as bodega_id
                , g.codigo as codigo_bodega
                , g.nombre as nombre_bodega
                , ROUND((a.cantidad / d.factor), 2) as cantidad_presentacion
                , c.id as producto_id
                , c.codigo as codigo_producto
                , c.nombre as nombre_producto
                , c.descripcion as descripcion_producto
                , c.peso
                , c.precio
                , d.id as presentacion_producto_id
                , d.nombre as nombre_presentacion
                , e.id as unidad_medida_id
                , e.nombre as nombre_unidad_medida
                , f.id as bodega_ubicacion_id
                , f.codigo as codigo_bodega_ubicacion
                , f.descripcion as descripcion_bodega_ubicacion
                , h.nombre as nombre_estado_producto
                , a.recepcion_enc_id")
                ->join("producto_bodega b", "a.producto_bodega_id = b.id")
                ->join("producto c", "b.producto_id = c.id")
                ->join("presentacion_producto d", "a.presentacion_producto_id = d.id", "left")
                ->join("unidad_medida e", "a.unidad_medida_id = e.id")
                ->join("bodega_ubicacion f", "a.bodega_ubicacion_id = f.id")
                ->join("bodega g", "b.bodega_id = g.id")
                ->join("estado_producto h", "a.estado_producto_id = h.id")
                ->join('stock_bodega_res i', 'b.id = i.producto_bodega_id', 'left')
                ->where('a.cantidad - IFNULL(i.cantidad, 0) > 0', null);

        $tmp = $builder->get();

        return verConsulta($tmp, $args);
    }
}
