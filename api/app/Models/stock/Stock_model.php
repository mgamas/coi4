<?php

namespace App\Models;

use CodeIgniter\Model;

class Stock_model extends General_model
{
    protected $table = 'stock_bodega';
    protected $primaryKey = 'id';
    
    protected $returnType = 'array';
    
    protected $allowedFields = [
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
        'despacho_enc_id'
    ];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla("stock_bodega");
        $this->setLlave("id");

        if (!empty($id)) {
            $this->cargar($id);
        }
    }
}

/* End of file Stock_model.php */
/* Location: ./app/Models/Stock_model.php */
