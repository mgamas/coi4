<?php

namespace App\Models\orden;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class OrdenCompraDetalle_model extends General_model {

    protected $table = 'orden_compra_det';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'orden_compra_enc_id',
        'no_linea',
        'codigo_producto',
        'nombre_producto',
        'nombre_presentacion',
        'nombre_unidad_medida',
        'cantidad',
        'cantidad_recibida',
        'costo',
        'total_linea',
        'peso',
        'peso_recibido',
        'activo',
        'producto_bodega_id',
        'presentacion_producto_id',
        'unidad_medida_id',
        'motivo_devolucion_id'
    ];

    public $orden_compra_enc_id;
    public $no_linea;
    public $codigo_producto;
    public $nombre_producto;
    public $nombre_presentacion;
    public $nombre_unidad_medida;
    public $cantidad;
    public $cantidad_recibida;
    public $costo;
    public $total_linea;
    public $peso;
    public $peso_recibido;
    public $activo;
    public $producto_bodega_id;
    public $presentacion_producto_id;
    public $unidad_medida_id;
    public $motivo_devolucion_id;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'id')) {
            $db->table($this->table)->where('ocd.id', $args['id']);
        }

        if (elemento($args, 'orden_compra_enc_id')) {
            $db->table($this->table)->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
        }

        if (elemento($args, 'no_linea')) {
            $db->table($this->table)->where('ocd.no_linea >', $args['no_linea']);
        }

        $tmp = $db->table($this->table . ' ocd')
            ->select('ocd.id, ocd.orden_compra_enc_id, ocd.no_linea, ocd.codigo_producto, ocd.nombre_producto, IFNULL(ocd.nombre_presentacion, "Sin Presentacion") as nombre_presentacion, IFNULL(ocd.nombre_unidad_medida, "Sin Unidad de Medida") as nombre_unidad_medida, ocd.cantidad, ocd.cantidad_recibida, ocd.costo, ocd.total_linea, ocd.peso, ocd.peso_recibido, ocd.activo, ocd.producto_bodega_id, ocd.presentacion_producto_id, ocd.unidad_medida_id, IFNULL(ocd.motivo_devolucion_id, "Sin Motivo Devolucion") as motivo_devolucion_id, p.id AS id_producto_j, p.codigo AS codigo_producto_j, p.nombre AS nombre_producto_j, IFNULL(pp.codigo, "Sin Presentacion") AS codigo_presentacion_j, IFNULL(pp.nombre, "Sin Presentacion") AS nombre_presentacion_j, IFNULL(um.nombre, "Sin Unidad de Medida") AS nombre_unidad_medida_j, IFNULL(md.nombre, "Sin Motivo Devolucion") AS nombre_motivo_dev')
            ->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id', 'left')
            ->join('unidad_medida um', 'um.id = ocd.unidad_medida_id', 'left')
            ->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id', 'left')
            ->where('ocd.activo', 1)
            ->get();

        return verConsulta($tmp, $args);
    }

    public function getLast($args = [])
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'orden_compra_enc_id')) {
            $db->table($this->table)->where('ocd.orden_compra_enc_id', $args['orden_compra_enc_id']);
        }

        if (elemento($args, 'no_linea')) {
            $db->table($this->table)->where('ocd.no_linea >', $args['no_linea']);
        }

        $tmp = $db->table($this->table . ' ocd')
            ->select('ocd.id, ocd.orden_compra_enc_id, ocd.no_linea, ocd.codigo_producto, ocd.nombre_producto, IFNULL(ocd.nombre_presentacion, "Sin Presentacion") as nombre_presentacion, IFNULL(ocd.nombre_unidad_medida, "Sin Unidad de Medida") as nombre_unidad_medida, ocd.cantidad, ocd.cantidad_recibida, ocd.costo, ocd.total_linea, ocd.peso, ocd.peso_recibido, ocd.activo, ocd.producto_bodega_id, ocd.presentacion_producto_id, ocd.unidad_medida_id, IFNULL(ocd.motivo_devolucion_id, "Sin Motivo Devolucion") as motivo_devolucion_id, p.id AS id_producto_j, p.codigo AS codigo_producto_j, p.nombre AS nombre_producto_j, IFNULL(pp.codigo, "Sin Presentacion") AS codigo_presentacion_j, IFNULL(pp.nombre, "Sin Presentacion") AS nombre_presentacion_j, IFNULL(um.nombre, "Sin Unidad de Medida") AS nombre_unidad_medida_j, IFNULL(md.nombre, "Sin Motivo Devolucion") AS nombre_motivo_dev')
            ->join('producto_bodega pb', 'pb.id = ocd.producto_bodega_id')
            ->join('producto p', 'p.id = pb.producto_id')
            ->join('presentacion_producto pp', 'pp.id = ocd.presentacion_producto_id', 'left')
            ->join('unidad_medida um', 'um.id = ocd.unidad_medida_id', 'left')
            ->join('motivo_devolucion md', 'md.id = ocd.motivo_devolucion_id', 'left')
            ->where('ocd.activo', 1)
            ->orderBy('1', 'desc')
            ->limit(1)
            ->get();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        $db = \Config\Database::connect();

        if ($this->getPK()) {
            $db->table($this->table)->where("id <>", $this->getPK());
        }

        $tmp = $db->table($this->table)
            ->where("no_linea", $args->no_linea)
            ->where("orden_compra_enc_id", $args->orden_compra_enc_id)
            ->where("activo", 1)
            ->get();

        return $tmp->getNumRows() > 0;
    }
}

/* End of file OrdenCompraDetalle_model.php */
/* Location: ./application/models/orden/detalle/OrdenCompraDetalle_model.php */
