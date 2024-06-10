<?php

namespace App\Models\Stock_res;

use App\Models\General_model;

class Stock_res_model extends General_model {

	protected $table = 'stock_bodega_res';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'tipo_transaccion_id', 
		'lote', 
		'fecha_vence', 
		'cantidad', 
		'peso', 
		'fecha_ingreso', 
		'activo', 
		'producto_bodega_id', 
		'bodega_id', 
		'estado_producto_id', 
		'presentacion_producto_id', 
		'unidad_medida_id', 
		'bodega_ubicacion_id', 
		'bodega_ubicacion_id_anterior', 
		'recepcion_enc_id', 
		'recepcion_det_id', 
		'pedido_enc_id', 
		'pedido_det_id', 
		'despacho_enc_id', 
		'stock_bodega_id'
	];

	public function __construct($id = "")
	{
		parent::__construct();
		
		if (!empty($id)) {
			$this->cargar($id);
		}
	}
}

