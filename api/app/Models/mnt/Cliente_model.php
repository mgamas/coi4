<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Cliente_model extends General_model {

    protected $table = 'cliente';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'nombre_comercial', 'telefono', 'nit', 'direccion', 'email', 'activo', 'cliente_tipo_id'
    ];

    public $codigo;
    public $nombre_comercial;
    public $telefono;
    public $nit;
    public $direccion;
    public $email;
    public $activo = 1;
    public $cliente_tipo_id;

    public function __construct($id = "")
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $query = $this->where('codigo', $args['codigo'])
                      ->where('nombre_comercial', $args['nombre_comercial'])
                      ->where('nit', $args['nit'])
                      ->get();

        return $query->getNumRows() > 0;
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('a.id', $args['id']);
        }

        if (isset($args['activo'])) {
            $this->where('a.activo', $args['activo']);
        } else {
            $this->where('a.activo', 1);
        }

        $query = $this->select('a.*, b.nombre as ncliente')
                      ->join('cliente_tipo b', 'b.id = a.cliente_tipo_id')
                      ->where('a.activo', 1)
                      ->get();

        return verConsulta($query, $args);
    }
}
