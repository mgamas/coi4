<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Pedido_tipo_model extends General_model {
    
    protected $table = 'pedido_tipo'; // Asumí que la tabla se llama 'pedido_tipo'
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'reservar_stock'];

    public $nombre;
    public $descripcion;
    public $reservar_stock;

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

/* End of file Pedido_tipo_model.php */
/* Location: ./application/models/Pedido_tipo_model.php */
