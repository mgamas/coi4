<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Empresa_model extends General_model {

    protected $table = 'empresa'; // Asumí que la tabla se llama 'empresa'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'razon_social', 'representante', 'nit', 
        'direccion', 'telefono', 'correo', 'logo', 
        'logo_enlace', 'activo'
    ];

    public $nombre;
    public $razon_social = null;
    public $representante;
    public $nit;
    public $direccion = null;
    public $telefono = null;
    public $correo = null;
    public $logo = null;
    public $logo_enlace = null;
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

    public function existe($args = []) {
        if ($this->getPK()) {
            $this->where("id <>", $this->getPK());
        }

        $tmp = $this->where("nit", $args['nit'])
                    ->where("nombre", $args['empresa'])
                    ->where("razon_social", $args['razon_social'])
                    ->where("representante", $args['representante'])
                    ->findAll();

        if (count($tmp) > 0) {
            return true;
        }

        return false;
    }    

}

/* End of file Empresa_model.php */
/* Location: ./application/models/Empresa_model.php */
