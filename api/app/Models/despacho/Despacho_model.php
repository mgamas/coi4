<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Despacho_model extends General_model {

    protected $table = 'despacho_enc';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'hora_inicio',
        'hora_fin',
        'observacion',
        'marchamo',
        'usuario_agr',
        'fecha_agr',
        'usuario_mod',
        'fecha_mod',
        'activo',
        'vehiculos_id',
        'bodega_id',
        'pilotos_id',
        'ruta_id',
        'tipo_transaccion_id',
        'estado'
    ];

    public $hora_inicio;
    public $hora_fin;
    public $observacion;
    public $marchamo;
    public $usuario_agr;
    public $fecha_agr;
    public $usuario_mod;
    public $fecha_mod;
    public $activo = 1;
    public $vehiculos_id;
    public $bodega_id;
    public $pilotos_id;
    public $ruta_id;
    public $tipo_transaccion_id;
    public $estado;

    public function __construct($id = '')
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

        if (elemento($args, "id")) {
            $db->table($this->table)->where("a.id", $args['id']);
        } else {
            if (elemento($args, "bodega_id")) {
                $db->table($this->table)->where("a.bodega_id", $args['bodega_id']);
            }

            if (elemento($args, 'criterio')) {
                $termino = trim($args['criterio']);
                $campos = [
                    'a.observacion'
                ];
                $where = implode(" like '%{$termino}%' or ", $campos);
                $db->table($this->table)->where("({$where} like '%{$termino}%')", null, false);
            } else {
                if (elemento($args, 'fdel') && elemento($args, 'fal')) {
                    $db->table($this->table)
                        ->where("CAST(a.fecha_agr as date) >=", $args["fdel"])
                        ->where("CAST(a.fecha_agr as date) <=", $args["fal"]);
                }
            }
        }

        $tmp = $db->table($this->table . ' a')
            ->select("a.*, 
                b.placa, 
                b.marca, 
                b.modelo, 
                c.nombre as nombre_bodega, 
                d.nombres as nombre_piloto, 
                d.apellidos as apelldiso_piloto,
                e.nombre as nombre_transaccion, 
                r.nombre as nombre_ruta"
            )
            ->join("vehiculos b", "b.id = a.vehiculos_id", "left")
            ->join("bodega c", "c.id = a.bodega_id")
            ->join("pilotos d", "d.id = a.pilotos_id", "left")
            ->join("ruta r", "r.id = a.ruta_id", "left")
            ->join("tipo_transaccion e", "e.id = a.tipo_transaccion_id")
            ->orderBy("a.id")
            ->get();

        return verConsulta($tmp, $args);
    }
}

/* End of file Despacho_model.php */
/* Location: ./application/models/Despacho_model.php */
