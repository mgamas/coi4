<?php

namespace App\Models\Stock_res;

use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use App\Models\General_model;

class Stock_res_model extends General_model
{
    protected $table = 'stock_bodega_res';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo_transaccion_id', 'lote', 'fecha_vence', 'cantidad', 'peso', 'fecha_ingreso', 
        'producto_bodega_id', 'bodega_id', 'estado_producto_id', 'presentacion_producto_id', 
        'unidad_medida_id', 'bodega_ubicacion_id', 'bodega_ubicacion_id_anterior', 
        'recepcion_enc_id', 'pedido_enc_id', 'pedido_det_id', 'despacho_enc_id', 'stock_bodega_id'
    ];

    public $tipo_transaccion_id = null;
    public $lote = null;
    public $fecha_vence = null;
    public $cantidad = null;
    public $peso = null;
    public $fecha_ingreso = null;
    public $producto_bodega_id;
    public $bodega_id;
    public $estado_producto_id;
    public $presentacion_producto_id = null;
    public $unidad_medida_id;
    public $bodega_ubicacion_id;
    public $bodega_ubicacion_id_anterior;
    public $recepcion_enc_id = null;
    public $pedido_enc_id = null;
    public $pedido_det_id = null;
    public $despacho_enc_id = null;
    public $stock_bodega_id = null;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function ObtenerReservaExistente($args = [])
    {
        $tmp = $this->where('pedido_enc_id', $args['datos']->pedido_enc_id)
                    ->where('pedido_det_id', $args['datos']->pedido_det_id)
                    ->first();

        return $tmp['id'] ?? null;
    }

    public function EliminarReserva($id)
    {
        $this->where('pedido_det_id', $id)->delete();

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            $this->setMensaje("No elimino la reserva, por favor intente nuevamente.");
            return false;
        }
    }
}
