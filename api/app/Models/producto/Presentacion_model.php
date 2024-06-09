<?php

namespace App\Models\producto;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Presentacion_model extends General_model {

    protected $table = 'presentacion_producto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'nombre', 'factor', 'producto_id', 'bodega_id', 'activo'];
    public $codigo;
    public $nombre;
    public $factor;
    public $producto_id;
    public $bodega_id;
    public $activo = 1;

    public function __construct($id = "")
    {
        parent::__construct();

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('id', $args['id']);
        }

        if (isset($args['activo'])) {
            $this->where('activo', $args['activo']);
        } else {
            $this->where('activo', 1);
        }

        if (elemento($args, 'producto')) {
            $this->where('producto_id', $args['producto']);
        }

        if (elemento($args, 'bodega')) {
            $this->where('bodega_id', $args['bodega']);
        }

        $query = $this->get();

        return verConsulta($query, $args);
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where('id !=', $this->getPK());
        }

        $query = $this->where('codigo', $args['codigo'])
                      ->where('factor', $args['factor'])
                      ->where('producto_id', $args['producto_id'])
                      ->where('bodega_id', $args['bodega_id'])
                      ->get();

        return $query->getNumRows() > 0;
    }
}
