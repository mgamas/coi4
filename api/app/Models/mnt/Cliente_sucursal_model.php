<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Cliente_sucursal_model extends General_model {

    protected $table = 'cliente_sucursal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sucursal_id', 'cliente_id', 'activo'];

    public $sucursal_id;
    public $cliente_id;
    public $activo = 1;

    public function __construct($id = "")
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    // Si tienes alguna función adicional, inclúyela aquí
}

