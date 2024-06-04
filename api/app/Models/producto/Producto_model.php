<?php

namespace App\Models;
use function App\Helpers\verConsulta;
use CodeIgniter\Model;

class Producto_model extends General_model
{
    protected $_table = 'producto'; // Asigna el nombre de la tabla correspondiente
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'codigo', 'barra', 'nombre', 'descripcion', 'imagen', 'img_enlace', 
        'costo', 'peso', 'largo', 'altura', 'anchura', 'precio', 'control_vence',
        'existencia_maxima', 'existencia_minima', 'activo', 'unidad_medida_id',
        'marca_producto_id', 'clasificacion_producto_id', 'estado_producto_id',
        'tipo_producto_id', 'familia_producto_id', 'usuario_agr'
    ];

    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        $builder = $this->db->table($this->_table . ' a');

        if (isset($args['id'])) {
            $builder->where('a.id', $args['id']);
        } else {
            if (isset($args['activo'])) {
                $builder->where('a.activo', $args['activo']);
            } else {
                $builder->where('a.activo', 1);
            }
        }

        $builder->select("a.*,
            b.nombre as um,
            c.nombre as nmarca,
            d.nombre as nclasificacion,
            e.nombre as nestado,
            e.utilizable, 
            e.danado,
            f.nombre as ntipo,
            h.nombre as nfamilia")
            ->join("unidad_medida b", "b.id = a.unidad_medida_id", "left")
            ->join("marca_producto c", "c.id = a.marca_producto_id", "left")
            ->join("clasificacion_producto d", "d.id = a.clasificacion_producto_id", "left")
            ->join("estado_producto e", "e.id = a.estado_producto_id", "left")
            ->join("tipo_producto f", "f.id = a.tipo_producto_id", "left")
            ->join("familia_producto h", "h.id = a.familia_producto_id", "left");

        $tmp = $builder->get();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        $builder = $this->db->table($this->_table);

        if ($this->getPK()) {
            $builder->where("id <>", $this->getPK());
        }

        $builder->where("nombre", $args['nombre'])
            ->where("codigo", $args['codigo'])
            ->where("barra", $args['barra']);

        $tmp = $builder->get();

        return $tmp->getNumRows() > 0;
    }
}

/* End of file Producto_model.php */
/* Location: ./app/Models/Producto_model.php */
