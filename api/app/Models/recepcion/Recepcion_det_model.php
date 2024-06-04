<?php namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Recepcion_det_model extends General_model {

    protected $table = 'recepcion_det';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'recepcion_enc_id', 'codigo_producto', 'no_linea', 'cantidad_recibida', 'nombre_producto',
        'nombre_presentacion', 'nombre_unidad_medida', 'nombre_producto_estado', 'lote', 'fecha_vence',
        'peso', 'peso_minimo', 'peso_maximo', 'observacion', 'costo', 'costo_oc', 'activo', 
        'producto_bodega_id', 'presentacion_producto_id', 'unidad_medida_id', 'estado_producto_id'
    ];

    public function __construct($id = '')
    {
        parent::__construct();
        
        if (!empty($id)) {
            $this->find($id);
        }    
    }

    public function existe($args = [])
    {
        $builder = $this->db->table($this->table);
        
        if ($this->primaryKey) {
            $builder->where('id <>', $this->primaryKey);
        }

        $tmp = $builder
            ->where('presentacion_producto_id', $args['presentacion_producto_id'])
            ->where('producto_bodega_id', $args['producto_bodega_id'])
            ->where('lote', $args['lote'])
            ->where("fecha_vence", $args['fecha_vence'])
            ->where("estado_producto_id", $args['estado_producto_id'])
            ->where("recepcion_enc_id", $args['recepcion_enc_id'])
            ->where("activo", 1)
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function existe_oc_rec($args = [])
    {
        $tmp = $this->db->table('recepcion_orden')
            ->where('orden_compra_enc_id', $args['oc'])
            ->where('recepcion_enc_id', $args['rec'])
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function setNoLinea($args = [])
    {
        $tmp = $this->db->table($this->table)
            ->select("count(*) + 1 as numero")
            ->where("recepcion_enc_id", $args['recepcion'])
            ->get()
            ->getRow();

        return $tmp->numero;
    }

    public function buscar($args = [])
    {    
        $builder = $this->db->table($this->table . ' a')
            ->select("a.*, c.id as id_producto, c.control_vence")
            ->join("producto_bodega b", "b.id = a.producto_bodega_id")
            ->join("producto c", "c.id = b.producto_id")
            ->where("a.activo", 1)
            ->orderBy("a.no_linea");

        if (elemento($args, 'id')) {
            $builder->where("a.id", $args['id']);
        } else {
            if (elemento($args, 'recepcion_enc_id')) {
                $builder->where("a.recepcion_enc_id", $args['recepcion_enc_id']);
            }
        }

        $tmp = $builder->get();

        return verConsulta($tmp, $args);
    }

    public function insert_rec_oc($args = [])
    {
        $this->db->table('recepcion_orden')->insert($args);

        return $this->db->affectedRows() > 0;
    }

}

/* End of file Recepcion_det_model.php */
/* Location: ./application/models/Recepcion_det_model.php */
