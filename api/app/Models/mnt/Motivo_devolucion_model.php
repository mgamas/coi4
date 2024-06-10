<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Motivo_devolucion_model extends General_model {
    
    protected $table = 'motivo_devolucion'; // Asumí que la tabla se llama 'motivo_devolucion'
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

        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where("id <>", $this->getPK());
        }

        $tmp = $this->where("nombre", $args['nombre'])
                    ->findAll();

        if (count($tmp) > 0) {
            return true;
        }

        return false;
    }    

}

/* End of file Motivo_devolucion_model.php */
/* Location: ./application/models/Motivo_devolucion_model.php */
