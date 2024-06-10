<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Empleado_model extends General_model {

    protected $table = 'empleado';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'nombre', 'apellido', 
        'telefono', 'direccion', 'correo', 
        'fecha_nac', 'activo', 'usuario_id'
    ];

    public $codigo;
    public $nombre;
    public $apellido;
    
    public $telefono;
    public $direccion;
    public $correo ;
    public $fecha_nac ;
    public $activo = 1;
    public $usuario_id;

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
            $this->where("id <>", $this->getPK());
        }

        $tmp = $this->where("nombre", $args['nombre'])
                    ->where("apellido", $args['apellido'])
                    ->where("activo", 1)
                    ->get();

        if ($tmp->getNumRows() > 0) {
            return true;
        }

        return false;
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where("id", $args['id']);
        }

        $tmp = $this->select("*")
                    ->where('activo', 1)
                    ->get();

        return verConsulta($tmp, $args);
    }
}
