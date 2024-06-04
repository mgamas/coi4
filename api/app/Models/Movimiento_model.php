<?php

namespace App\Models;

use CodeIgniter\Model;

class Movimiento_model extends General_model
{
    protected $table = 'movimientos_bodega';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'cantidad', 'peso', 'lote', 'fechaVence', 'horaInicio', 'horaFinal', 'cantHist', 'pesoHist', 
        'fechaOperacion', 'usuario_agr', 'tipo_transaccion_id', 'producto_bodega_id', 'empresa_id',
        'presentacion_producto_id', 'bodega_ubicacion_id_origen', 'bodega_ubicacion_id_destino', 
        'bodega_id_origen', 'bodega_id_destino', 'estado_producto_id_origen', 'estado_producto_id_destino', 
        'unidad_medida_id', 'recepcion_enc_id', 'despacho_enc_id'
    ];
    
    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla("movimientos_bodega");
        $this->setLlave("id");

        if (!empty($id)) {
            $this->cargar($id);
        }
    }
}

/* End of file Movimiento_model.php */
/* Location: ./app/Models/Movimiento_model.php */
