<?php

namespace App\Models\mnt;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Menu_model extends General_model {

    protected $table = 'modulo';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'url', 'icono', 'activo', 'titulo'
    ];

    public $nombre;
    public $url;
    public $icono;
    public $activo = 1;
    public $titulo = 0;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla("modulo");
        $this->setLlave("id");

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where("id", $args['id']);
        }

        if (elemento($args, 'rol_id')) {
            $this->join("modulo_rol mr", "modulo.id = mr.modulo_id");
            $this->where("mr.rol_id", $args['rol_id']);
            $this->where("mr.activo", "1");
        }

        $tmp =$this->where("activo", 1)->get();
        //$tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe_menu($args = [])
    {    
        if ($this->getPK()) {
            $this->where("id <>", $this->getPK());
        }

        $tmp = $this->where("ruta", $args['ruta'])
                    ->get();

        return $tmp->getNumRows() == 0;
    }
}

/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
