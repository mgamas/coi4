<?php

namespace App\Models\despacho;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Despacho_det_model extends General_model {

    protected $table = 'despacho_det';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'despacho_enc_id',
        'codigo_producto',
        'no_linea',
        'cantidad_despachada',
        'peso_despachado',
        'nombre_producto',
        'nombre_presentacion',
        'nombre_unidad_medida',
        'nombre_estado_producto',
        'activo',
        'producto_bodega_id',
        'presentacion_producto_id',
        'unidad_medida_id',
        'estado_producto_id',
        'pedido_enc_id',
        'pedido_det_id'
    ];

    public $despacho_enc_id;
    public $codigo_producto;
    public $no_linea;
    public $cantidad_despachada;
    public $peso_despachado;
    public $nombre_producto;
    public $nombre_presentacion;
    public $nombre_unidad_medida;
    public $nombre_estado_producto;
    public $activo = 1;
    public $producto_bodega_id;
    public $presentacion_producto_id = null;
    public $unidad_medida_id;
    public $estado_producto_id;
    public $pedido_enc_id;
    public $pedido_det_id;

    public function __construct($id = '')
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }    
    }

    public function existe($args = [])
    {
        $db = \Config\Database::connect();

        if ($this->getPK()) {
            $db->table($this->table)->where('id <> ', $this->getPK());
        }

        $tmp = $db->table($this->table)
            ->where('presentacion_producto_id', $args->presentacion_producto_id)
            ->where('producto_bodega_id', $args->producto_bodega_id)
            ->where("estado_producto_id", $args->estado_producto_id)
            ->where("despacho_enc_id", $args->despacho_enc_id)
            ->where("activo", 1)
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function existe_pedido_despacho($args = [])
    {
        $db = \Config\Database::connect();

        $tmp = $db->table($this->table)
            ->where('pedido_enc_id', $args['oc'])
            ->where('pedido_det_id', $args['det'])
            ->where('despacho_enc_id', $args['rec'])
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function setNoLinea($args = [])
    {
        $db = \Config\Database::connect();

        $tmp = $db->table($this->table)
            ->select("count(*) + 1 as numero")
            ->where("despacho_enc_id", $args['despacho'])
            ->get()
            ->getRow();

        return $tmp->numero;
    }

    public function _buscar($args = '')
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'id')) {
            $db->table($this->table)->where("a.id", $args['id']);
        } else {
            if (elemento($args, 'despacho_enc_id')) {
                $db->table($this->table)->where("a.despacho_enc_id", $args['despacho_enc_id']);
            }
        }

        $tmp = $db->table($this->table . ' a')
            ->select("a.*, c.id as id_producto, c.control_vence")
            ->join("producto_bodega b", "b.id = a.producto_bodega_id")
            ->join("producto c", "c.id = b.producto_id")
            ->where("a.activo", 1)
            ->orderBy("a.no_linea")
            ->get();

        return verConsulta($tmp, $args);
    }
}

/* End of file Despacho_det_model.php */
/* Location: ./application/models/Despacho_det_model.php */
