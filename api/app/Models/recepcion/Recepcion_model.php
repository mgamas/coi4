<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Recepcion_model extends General_model {

    protected $table = 'recepcion_enc';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fecha_recepcion', 'hora_inicio', 'hora_fin', 'observacion', 'no_guia',
        'anulada', 'ingresa_stock', 'no_marchamo', 'usuario_agr', 'fecha_agr',
        'usuario_mod', 'fecha_mod', 'activo', 'vehiculos_id', 'bodega_id', 'pilotos_id',
        'tipo_transaccion_id', 'estado_recepcion_id'
    ];

    public $fecha_recepcion;
    public $hora_inicio;
    public $hora_fin;
    public $observacion;
    public $no_guia;
    public $anulada = 0;
    public $ingresa_stock = 0;
    public $no_marchamo;
    public $usuario_agr;
    public $fecha_agr;
    public $usuario_mod;
    public $fecha_mod;
    public $activo = 1;
    public $vehiculos_id;
    public $bodega_id;
    public $pilotos_id;
    public $tipo_transaccion_id;
    public $estado_recepcion_id;

    public function __construct($id = null) {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function _buscar($args = []) {
        $builder = $this->db->table($this->table . ' a');

        if (elemento($args, 'id')) {
            $builder->where('a.id', $args['id']);
        } else {
            if (elemento($args, 'bodega_id')) {
                $builder->where('a.bodega_id', $args['bodega_id']);
            }

            if (elemento($args, 'criterio')) {
                $termino = trim($args['criterio']);
                $campos = [
                    'a.observacion',
                    'a.no_guia'
                ];

                $where = implode(" LIKE '%{$termino}%' OR ", $campos);
                $builder->where("({$where} LIKE '%{$termino}%')", null, false);
            } else {
                if (elemento($args, 'fdel') && elemento($args, 'fal')) {
                    $builder->where('CAST(a.fecha_agr AS DATE) >=', $args['fdel'])
                            ->where('CAST(a.fecha_agr AS DATE) <=', $args['fal']);
                }
            }
        }

        $builder->select('a.*, 
            b.placa, 
            b.marca, 
            b.modelo, 
            c.nombre as nombre_bodega, 
            d.nombres as nombre_piloto, 
            d.apellidos as apellidos_piloto,
            e.nombre as nombre_transaccion, 
            f.nombre as nombre_estado,
            f.color as nombre_color')
                ->join('vehiculos b', 'b.id = a.vehiculos_id', 'left')
                ->join('bodega c', 'c.id = a.bodega_id')
                ->join('pilotos d', 'd.id = a.pilotos_id', 'left')
                ->join('tipo_transaccion e', 'e.id = a.tipo_transaccion_id')
                ->join('estado_recepcion f', 'f.id = a.estado_recepcion_id')
                ->orderBy('a.id');

        $query = $builder->get();
        return verConsulta($query, $args);
    }
}
