<?php

namespace App\Models\mnt;

use App\Models\General_model;

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
