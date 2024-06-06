<?php

namespace App\Models;

use CodeIgniter\Model;

class Empleado_sucursal_model extends General_model {

    protected $table = 'empleado_sucursal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'sucursal_id', 'empleado_id', 'activo'
    ];

    public $sucursal_id;
    public $empleado_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }
}
