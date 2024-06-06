<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario_sucursal_model extends General_model {

    protected $table = 'usuario_sucursal'; // Asumí que la tabla se llama 'usuario_sucursal'
    protected $primaryKey = 'id';
    protected $allowedFields = ['sucursal_id', 'usuario_id', 'activo'];

    public $sucursal_id;
    public $usuario_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

}

/* End of file Usuario_sucursal_model.php */
/* Location: ./application/models/Usuario_sucursal_model.php */
