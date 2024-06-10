<?php

namespace App\Models\mnt;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Vehiculos_model extends General_model {

    protected $table = 'vehiculos'; // Asumí que la tabla se llama 'vehiculos'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo', 'placa', 'marca', 'modelo', 'peso', 
        'volumen', 'alto', 'largo', 'ancho', 
        'placa_comercial', 'es_contenedor', 
        'usuario_agr', 'fecha_agr', 
        'usuario_mod', 'fecha_mod', 'activo'
    ];

    public $tipo;
    public $placa;
    public $marca;
    public $modelo;
    public $peso;
    public $volumen;
    public $alto;
    public $largo;
    public $ancho;
    public $placa_comercial;
    public $es_contenedor;
    public $usuario_agr;
    public $fecha_agr;
    public $usuario_mod;
    public $fecha_mod;
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
        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('placa', $args['placa'])
                    ->where('activo', 1)
                    ->findAll();

        return count($tmp) > 0;
    }    

}

/* End of file Vehiculos_model.php */
/* Location: ./application/models/Vehiculos_model.php */
