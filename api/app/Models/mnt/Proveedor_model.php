<?php

namespace App\Models\mnt;

use App\Models\General_model;
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
            $this->where('id', $args['id']);
        }

       /*  $tmp = $this->select('*, b.nombre as Empresa')
                    ->join('empresa b', 'b.id = empresa_id')
                    ->where('activo', 1)
                    ->get(); */
        
        $builder = $this->db->table($this->table);
        $builder->select('*, b.nombre as Empresa');
        $builder->join('empresa b', 'b.id = empresa_id');
        $builder->where('proveedor.activo', 1);
        if (elemento($args, 'id')) {
            $builder->where('id', $args['id']);
        }

        $query = $builder->get();

        return verConsulta($query, $args);
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
