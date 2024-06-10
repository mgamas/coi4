<?php

namespace App\Models\mnt;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Cliente_contacto_model extends General_model {

    protected $table = 'cliente_contacto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'telefono', 'email', 'activo', 'cliente_id'];

    public $nombre;
    public $telefono;
    public $email;
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
