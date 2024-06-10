<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Tipo_transaccion_model extends General_model {

    protected $table = 'tipo_transaccion'; // Asumí que la tabla se llama 'tipo_transaccion'
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'activo'];

    public $nombre;
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

        $this->where('activo', 1);
        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('nombre', $args['nombre'])
                    ->where('activo', 1)
                    ->findAll();

        return count($tmp) > 0;
    }

}

/* End of file Tipo_transaccion_model.php */
/* Location: ./application/models/Tipo_transaccion_model.php */
