<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Rol_model extends General_model {

    protected $table = 'rol'; // Asumí que la tabla se llama 'rol'
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
    
    public function existe_rol($args = [])
    {    
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('nombre', $args['nombre'])
                    ->findAll();

        return count($tmp) == 0;
    }

}

/* End of file Rol_model.php */
/* Location: ./application/models/Rol_model.php */
