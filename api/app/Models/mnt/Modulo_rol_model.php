<?php

namespace App\Models;

use CodeIgniter\Model;

class Modulo_rol_model extends General_model {
    
    protected $table = 'modulo_rol';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'modulo_id', 'rol_id', 'activo'
    ];

    public $modulo_id;
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

/* End of file Modulo_rol_model.php */
/* Location: ./application/models/Modulo_rol_model.php */
