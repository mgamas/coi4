<?php

namespace App\Models\pedido;

use App\Models\General_model;
use CodeIgniter\Model;
use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Pedido_det_model extends General_model
{
    protected $table = 'pedido_det';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_enc_id',
        'no_linea',
        'cantidad',
        'peso',
        'precio',
        'cantidad_despachada',
        'codigo_producto',
        'nombre_producto',
        'nombre_presentacion',
        'nombre_unidad_medida',
        'nombre_estado_producto',
        'producto_bodega_id',
        'presentacion_producto_id',
        'unidad_medida_id',
        'estado_producto_id',
        'activo',
        'lote',
        'fecha_vence'
    ];

    public function __construct($id = null)
    {
        parent::__construct();
        $this->setTabla("pedido_det");
        $this->setLlave("id");

        if (!empty($id)) {
            $this->cargar($id);
        }    
    }

    public function existe($args = [])
    {
        $tmp = $this->db->table($this->table)
            ->where("pedido_enc_id", $args['pedido_enc_id'])
            ->where("id", $this->getPK())
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function obtenerUltimaLinea($args = [])
    {
        $tmp = $this->db->table($this->table)
            ->select("MAX(no_linea) + 1 as numero")
            ->where("pedido_enc_id", $args['pedido'])
            ->get()
            ->getRow();

        return $tmp->numero;
    }

    public function _buscar($args = '')
    {
        $builder = $this->db->table($this->table . ' a');
        
        if (elemento($args, 'id')) {
            $builder->where("a.id", $args['id']);
        } else {
            if (elemento($args, 'pedido_enc_id')) {
                $builder->where("a.pedido_enc_id", $args['pedido_enc_id']);
            }
        }

        $tmp = $builder
            ->select("a.*")
            ->where('a.activo', 1)
            ->orderBy("a.no_linea")
            ->get();

        return verConsulta($tmp, $args);
    }

    public function obtenerDetalleExistente($args = [])
    {
        $fecha_vence = isset($args['datos']->fecha_vence) && !empty($args['datos']->fecha_vence) 
            ? (new \DateTime($args['datos']->fecha_vence))->format('Y-m-d H:i:s') 
            : null;

        $lote = isset($args['datos']->lote) ? $args['datos']->lote : null;

        $condicion = $fecha_vence !== null 
            ? "a.fecha_vence = '$fecha_vence'" 
            : "a.fecha_vence IS NULL";

        $condicion .= $lote !== null 
            ? " AND a.lote = '$lote'" 
            : " AND a.lote IS NULL";

        $consulta = $this->db->table($this->table . ' a')
            ->select("a.id")
            ->where("a.pedido_enc_id", $args['datos']->pedido_enc_id)
            ->where("a.presentacion_producto_id", $args['datos']->presentacion_producto_id)
            ->where('a.unidad_medida_id', $args['datos']->unidad_medida_id)
            ->where($condicion)
            ->get();

        $resultado = $consulta->getResult();

        return $resultado[0]->id ?? null;
    }

    public function eliminarDetallePedido($id)
    {
        $this->db->table($this->table)
            ->delete(['id' => $id]);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            $this->setMensaje("No se eliminó el detalle, por favor intente nuevamente.");
            return false;
        }
    }
}

/* End of file Pedido_det_model.php */
/* Location: ./application/models/Pedido_det_model.php */
