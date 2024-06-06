<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu_rol_model extends General_model {
    
    protected $table = 'menu_rol';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'menu_modulo_id', 'rol_id', 'activo'
    ];

    public $menu_modulo_id;
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

/* End of file Menu_rol_model.php */
/* Location: ./application/models/Menu_rol_model.php */
