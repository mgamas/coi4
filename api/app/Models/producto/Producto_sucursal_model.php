<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Producto_sucursal_model extends General_model {

    protected $table = 'producto_sucursal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['activo', 'producto_id', 'sucursal_id'];

    public $activo = 1;
    public $producto_id;
    public $sucursal_id;

    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

}

/* End of file Producto_sucursal_model.php */
/* Location: ./app/Models/Producto_sucursal_model.php */
