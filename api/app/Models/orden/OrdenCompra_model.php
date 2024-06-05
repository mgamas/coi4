<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class OrdenCompra_model extends General_model {

    protected $table = 'orden_compra_enc';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_documento',
        'procedencia',
        'referencia',
        'observacion',
        'activo',
        'proveedor_bodega_id',
        'orden_compra_estado_id',
        'orden_compra_tipo_id',
        'motivo_devolucion_id',
        'bodega_id'
    ];

    public $no_documento;
    public $procedencia;
    public $referencia;
    public $observacion;
    public $activo;
    public $proveedor_bodega_id;
    public $orden_compra_estado_id;
    public $orden_compra_tipo_id;
    public $motivo_devolucion_id;
    public $bodega_id;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'id')) {
            $db->table($this->table)->where('oce.id', $args['id']);
        } else {
            if (elemento($args, "bodega_id")) {
                $db->table($this->table)->where("b.id", $args['bodega_id']);
            }

            if (elemento($args, 'criterio')) {
                $termino = trim($args['criterio']);
                $campos = [
                    'oce.no_documento',
                    'oce.procedencia',
                    'oce.referencia',
                    'oce.observacion'
                ];
                $where = implode(" like '%{$termino}%' or ", $campos);
                $db->table($this->table)->where("({$where} like '%{$termino}%')", null, false);
            } else {
                if (elemento($args, 'fdel') && elemento($args, 'fal')) {
                    $db->table($this->table)
                        ->where("CAST(oce.fecha_creacion as date) >=", $args["fdel"])
                        ->where("CAST(oce.fecha_creacion as date) <=", $args["fal"]);
                }
            }
        }

        $tmp = $db->table($this->table . ' oce')
            ->select("oce.*, p.nombre as nombre_proveedor, b.nombre as nombre_bodega, oce2.nombre as nombre_estado_oc, oct2.nombre as nombre_tipo_oc, md.nombre as nombre_motivo_dev")
            ->join("proveedor_bodega pb", "oce.proveedor_bodega_id = pb.id")
            ->join("proveedor p", "pb.proveedor_id = p.id")
            ->join("bodega b", "pb.bodega_id = b.id")
            ->join("orden_compra_estado oce2", "oce.orden_compra_estado_id = oce2.id")
            ->join("orden_compra_tipo oct2", "oce.orden_compra_tipo_id = oct2.id")
            ->join("motivo_devolucion md", "oce.motivo_devolucion_id = md.id", "left")
            ->get();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        $db = \Config\Database::connect();

        if ($this->getPK()) {
            $db->table($this->table)->where("id <>", $this->getPK());
        }

        $tmp = $db->table($this->table)
            ->where("no_documento", $args->no_documento)
            ->get();

        return $tmp->getNumRows() > 0;
    }
}

/* End of file OrdenCompra_model.php */
/* Location: ./application/models/OrdenCompra_model.php */
