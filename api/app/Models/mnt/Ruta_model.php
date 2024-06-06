<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Ruta_model extends General_model {
    
    protected $table = 'ruta'; // Asumí que la tabla se llama 'ruta'
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'nombre', 'vendedor', 'venta'];

    public $codigo;
    public $nombre;
    public $vendedor;
    public $venta;

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
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('codigo', $args['codigo'])
                    ->where('nombre', $args['nombre'])
                    ->where('vendedor', $args['vendedor'])
                    ->findAll();

        return count($tmp) > 0;
    }    

}

/* End of file Ruta_model.php */
/* Location: ./application/models/Ruta_model.php */
