<?php

namespace App\Models\producto;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Producto_bodega_model extends General_model {

    protected $table = 'producto_bodega';
    protected $primaryKey = 'id'; // Assuming there's a primary key named 'id'. Adjust if necessary.
    protected $allowedFields = ['producto_id', 'bodega_id', 'fecha', 'activo'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Assuming there's no created_at and updated_at fields. Adjust if necessary.

    public $producto_id;
    public $bodega_id;
    public $fecha;
    public $activo = 1;

    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }
}
