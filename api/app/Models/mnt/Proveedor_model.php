<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Proveedor_model extends General_model {

    protected $table = 'proveedor'; // Asumí que la tabla se llama 'proveedor'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'nombre', 'telefono', 'nit', 
        'direccion', 'email', 'contacto', 
        'muestra_precio', 'activo', 'empresa_id'
    ];

    public $codigo;
    public $nombre;
    public $telefono;
    public $nit;
    public $direccion;
    public $email;
    public $contacto;
    public $muestra_precio = 1;
    public $activo = 1;
    public $empresa_id;

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
            $this->where('a.id', $args['id']);
        }

        $tmp = $this->select('a.*, b.nombre as Empresa')
                    ->join('empresa b', 'b.id = a.empresa_id')
                    ->where('a.activo', 1)
                    ->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        if ($this->getPK()) {
            $this->where('id <>', $this->getPK());
        }

        $tmp = $this->where('nombre', $args['nombre'])
                    ->where('nit', $args['nit'])
                    ->where('email', $args['email'])
                    ->where('contacto', $args['contacto'])
                    ->findAll();

        if (count($tmp) > 0) {
            return true;
        }

        return false;
    }

}

/* End of file Proveedor_model.php */
/* Location: ./application/models/Proveedor_model.php */
