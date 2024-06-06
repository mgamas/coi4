<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Sucursal_model extends General_model {
    
    protected $table = 'sucursal'; // Asumí que la tabla se llama 'sucursal'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'razon_social', 'telefono', 
        'direccion', 'encargado', 'correo', 
        'activo', 'empresa_id', 'usuario_id'
    ];

    public $nombre;
    public $razon_social = null;
    public $telefono = null;
    public $direccion = null;
    public $encargado = null;
    public $correo = null;
    public $activo = 1;
    public $empresa_id;
    public $usuario_id;

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
            $this->where('sucursal.id', $args['id']);
        }
        
        $this->select('sucursal.*, empresa.nombre as nempresa')
             ->join('empresa', 'empresa.id = sucursal.empresa_id')
             ->where('sucursal.activo', 1);
        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe_sucursal($args = [])
    {    
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('nombre', $args['nombre'])
                    ->where('empresa_id', $args['empresa_id'])
                    ->where('activo', 1)
                    ->findAll();

        return count($tmp) == 0;
    }

}

/* End of file Sucursal_model.php */
/* Location: ./application/models/Sucursal_model.php */
