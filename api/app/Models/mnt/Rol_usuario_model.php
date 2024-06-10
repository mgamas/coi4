<?php

namespace App\Models\mnt;

use App\Models\General_model;

class Rol_usuario_model extends General_model {

    protected $table = 'rol_usuario'; // Asumí que la tabla se llama 'rol_usuario'
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'rol_id', 'activo'];

    public $usuario_id;
    public $rol_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

}

/* End of file Rol_usuario_model.php */
/* Location: ./application/models/Rol_usuario_model.php */
