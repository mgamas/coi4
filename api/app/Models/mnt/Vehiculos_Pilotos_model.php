<?php

namespace App\Models\mnt;

use App\Models\General_model;
use CodeIgniter\Model;

class Vehiculos_Pilotos_model extends General_model {

    protected $table = 'vehiculos_pilotos'; // Asumí que la tabla se llama 'vehiculos_pilotos'
    protected $primaryKey = 'id';
    protected $allowedFields = ['vehiculos_id', 'pilotos_id', 'activo'];

    public $vehiculos_id;
    public $pilotos_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

}

/* End of file Vehiculos_Pilotos_model.php */
/* Location: ./application/models/Vehiculos_Pilotos_model.php */
