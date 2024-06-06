<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Pilotos_model extends General_model {

    protected $table = 'pilotos'; // Asumí que la tabla se llama 'pilotos'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres', 'apellidos', 'telefono', 'email', 'no_licencia', 
        'no_dpi', 'fecha_expira_licencia', 'direccion', 'foto', 
        'fecha_nacimiento', 'tipo_licencia', 'activo'
    ];

    public $nombres;
    public $apellidos;
    public $telefono;
    public $email;
    public $no_licencia;
    public $no_dpi;
    public $fecha_expira_licencia;
    public $direccion;
    public $foto;
    public $fecha_nacimiento;
    public $tipo_licencia;
    public $activo;

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

        $tmp = $this->where('no_licencia', $args['no_licencia'])
                    ->where('no_dpi', $args['no_dpi'])
                    ->where('activo', 1)
                    ->findAll();

        if (count($tmp) > 0) {
            return true;
        }

        return false;
    }    

}

/* End of file Pilotos_model.php */
/* Location: ./application/models/Pilotos_model.php */
