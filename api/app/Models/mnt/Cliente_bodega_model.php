<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Cliente_bodega_model extends General_model {

    protected $table = 'cliente_bodega'; // Asegúrate de especificar el nombre de la tabla si es diferente
    protected $primaryKey = 'id'; // Asegúrate de especificar la clave primaria si es diferente
    protected $allowedFields = ['bodega_id', 'cliente_id', 'activo'];

    public $bodega_id;
    public $cliente_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    // Si tienes alguna función adicional, inclúyela aquí
}

