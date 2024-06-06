<?php

namespace App\Models;

use CodeIgniter\Model;

class Proveedor_bodega_model extends General_model {

    protected $table = 'proveedor_bodega'; // Asumí que la tabla se llama 'proveedor_bodega'
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'proveedor_id', 'bodega_id', 'usuario_agr', 'fecha_agr', 'activo'
    ];

    public $proveedor_id;
    public $bodega_id;
    public $usuario_agr;
    public $fecha_agr;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

}

/* End of file Proveedor_bodega_model.php */
/* Location: ./application/models/Proveedor_bodega_model.php */
