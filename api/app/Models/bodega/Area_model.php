<?php

namespace App\Models;

use CodeIgniter\Model;

class Area_Model extends General_model
{
    protected $table = 'bodega_area';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo', 'descripcion', 'largo', 'ancho', 'alto', 'activo', 'bodega_id'
    ];
    protected $useTimestamps = false;

    public function __construct($id = "")
    {
        parent::__construct();

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = [])
    {
        $builder = $this->db->table($this->table . ' a')
            ->select("a.*, b.nombre as nombre_bodega")
            ->join("bodega b", "b.id = a.bodega_id")
            ->where('a.activo', 1);

        if (!empty($args['id'])) {
            $builder->where("a.id", $args['id']);
        }

        if (!empty($args['bodega_id'])) {
            $builder->where("a.bodega_id", $args['bodega_id']);
        }

        $query = $builder->get();
        return $query->getResult();
    }
}
