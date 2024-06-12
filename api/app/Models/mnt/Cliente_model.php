<?php

namespace App\Models\mnt;

use App\Models\General_model;
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
        $builder = $this->db->table('cliente a');
    
        if (isset($args['id'])) {
            $builder->select('a.*')
                    ->where('a.id', $args['id']);
        }
    
        if (isset($args['activo'])) {
            $builder->where('a.activo', $args['activo']);
        } else {
            $builder->where('a.activo', 1);
        }
    
        $builder->select('a.*, b.nombre as ncliente')
                ->join('cliente_tipo b', 'b.id = a.cliente_tipo_id');
    
        $query = $builder->get();
    
        return verConsulta($query, $args);
    }
    

}
