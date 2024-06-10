<?php

namespace App\Models\bodega;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Tramo_model extends General_model {

    protected $table = 'bodega_tramo';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo',
        'descripcion',
        'largo',
        'ancho',
        'alto',
        'activo',
        'bodega_id',
        'bodega_area_id',
        'bodega_sector_id'
    ];

    public $codigo;
    public $descripcion;
    public $largo = 0;
    public $ancho = 0;
    public $alto = 0;
    public $activo = 1;
    public $bodega_id;
    public $bodega_area_id;
    public $bodega_sector_id;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = [])
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'id')) {
            $db->table($this->table)->where("a.id", $args['id']);
        }

        if (elemento($args, 'bodega_id')) {
            $db->table($this->table)->where("a.bodega_id", $args['bodega_id']);
        }

        if (elemento($args, 'bodega_area_id')) {
            $db->table($this->table)->where("a.bodega_area_id", $args['bodega_area_id']);
        }

        $tmp = $db->table($this->table . ' a')
            ->select("a.*, 
                b.nombre as nombre_bodega,
                c.codigo as codigo_area,
                c.descripcion as nombre_area,
                d.codigo as codigo_sector,
                d.descripcion as nombre_sector")
            ->join("bodega b", "b.id = a.bodega_id")
            ->join("bodega_area c", "c.id = a.bodega_area_id")
            ->join("bodega_sector d", "d.id = a.bodega_sector_id")
            ->where('a.activo', 1)
            ->get();

        return verConsulta($tmp, $args);
    }
}

/* End of file Tramo_model.php */
/* Location: ./application/models/Tramo_model.php */
