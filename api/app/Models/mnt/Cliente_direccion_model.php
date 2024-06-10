<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Cliente_direccion_model extends General_model {

    protected $table = 'cliente_direccion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'avenida', 'calle', 'no_casa', 'zona', 'direccion', 'referencia',
        'coordenada_x', 'coordenada_y', 'local', 'activo', 'cliente_id'
    ];

    public $avenida;
    public $calle;
    public $no_casa;
    public $zona;
    public $direccion;
    public $referencia;
    public $coordenada_x;
    public $coordenada_y;
    public $local;
    public $activo = 1;
    public $cliente_id;

    public function __construct($id = "")
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('id', $args['id']);
        }

        if (elemento($args, 'cliente_id')) {
            $this->where('cliente_id', $args['cliente_id']);
        }

        $query = $this->get();

        return verConsulta($query, $args);
    }
}
