<?php

namespace App\Models\producto;

use App\Models\General_model;

class Producto_sucursal_model extends General_model
{
    protected $table = 'producto_sucursal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_id', 'activo', 'sucursal_id'];

    public $producto_id;
    public $activo = 1;
    public $sucursal_id;
    

    public function __construct()
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }
}
