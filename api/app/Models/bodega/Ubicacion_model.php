<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Ubicacion_model extends General_model
{
    protected $table = 'bodega_ubicacion';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'codigo', 'descripcion', 'largo', 'ancho', 'alto', 'activa', 
        'bodega_id', 'bodega_area_id', 'bodega_sector_id', 
        'bodega_tramo_id', 'rotacion_id', 'nivel', 'danado', 
        'bloqueada', 'virtual', 'ubicacion_picking', 
        'ubicacion_recepcion', 'ubicacion_despacho', 
        'ubicacion_merma'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function __construct($id = null)
    {
        parent::__construct();
        
        if ($id !== null) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = [])
    {
        $builder = $this->db->table($this->table . ' a')
                            ->select("a.*, 
                                      b.nombre as nombre_bodega,
                                      c.codigo as codigo_area,
                                      c.descripcion as nombre_area,
                                      d.codigo as codigo_sector,
                                      d.descripcion as nombre_sector,
                                      e.codigo as codigo_tramo,
                                      e.descripcion as nombre_tramo,
                                      f.nombre as nombre_rotacion")
                            ->join("bodega b", "b.id = a.bodega_id")
                            ->join("bodega_area c", "c.id = a.bodega_area_id")
                            ->join("bodega_sector d", "d.id = a.bodega_sector_id")
                            ->join("bodega_tramo e", "e.id = a.bodega_tramo_id")
                            ->join("rotacion f", "f.id = a.rotacion_id")
                            ->where('a.activa', 1);

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        }

        if (elemento($args, 'bodega_id')) {
            $builder->where('a.bodega_id', $args['bodega_id']);
        }

        if (elemento($args, 'bodega_area_id')) {
            $builder->where('a.bodega_area_id', $args['bodega_area_id']);
        }

        $query = $builder->get();
        return verConsulta($query, $args);
    }
}
