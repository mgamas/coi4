<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Pedido_det_model extends General_model {

    protected $table = 'pedido_det';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_enc_id',
        'no_linea',
        'cantidad',
        'peso',
        'precio',
        'cantidad_despachada',
        'codigo_producto',
        'nombre_producto',
        'nombre_presentacion',
        'nombre_unidad_medida',
        'nombre_estado_producto',
        'producto_bodega_id',
        'presentacion_producto_id',
        'unidad_medida_id',
        'estado_producto_id'
    ];

    public $pedido_enc_id;
    public $no_linea;
    public $cantidad;
    public $peso;
    public $precio;
    public $cantidad_despachada;
    public $codigo_producto;
    public $nombre_producto;
    public $nombre_presentacion;
    public $nombre_unidad_medida;
    public $nombre_estado_producto;
    public $producto_bodega_id;
    public $presentacion_producto_id;
    public $unidad_medida_id;
    public $estado_producto_id;

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
            ->where("pedido_enc_id", $args->pedido_enc_id)
            ->where("activo", 1)
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function setNoLinea($args = [])
    {
        $db = \Config\Database::connect();

        $tmp = $db->table($this->table)
            ->select("count(*) + 1 as numero")
            ->where("pedido_enc_id", $args['pedido'])
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
            if (elemento($args, 'pedido_enc_id')) {
                $db->table($this->table)->where("a.pedido_enc_id", $args['pedido_enc_id']);
            }
        }

        $tmp = $db->table($this->table . ' a')
            ->select("a.*")
            ->orderBy("a.no_linea")
            ->get();

        return verConsulta($tmp, $args);
    }
}

/* End of file Pedido_det_model.php */
/* Location: ./application/models/Pedido_det_model.php */
