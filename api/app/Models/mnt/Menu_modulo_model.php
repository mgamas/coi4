<?php

namespace App\Models\mnt;

use App\Models\General_model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Menu_modulo_model extends General_model {

    protected $table = 'menu_modulo';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'icono', 'url', 'activo', 'modulo_id'
    ];

    public $nombre;
    public $icono;
    public $url;
    public $activo = 1;
    public $modulo_id;

    public function __construct($id = "")
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'modulo')) {
            $this->where('modulo_id', $args['modulo']);
        }

        if (elemento($args, 'id')) {
            $this->where('id', $args['id']);
        }

        if (elemento($args, 'rol_id')) {
            $this->join("menu_rol mr", "menu_modulo.id = mr.menu_modulo_id");
            $this->where("mr.rol_id", $args['rol_id']);
            $this->where("mr.activo", "1");
        }
        
        $this->where("activo", 1);
        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

}

/* End of file Menu_modulo_model.php */
/* Location: ./application/models/Menu_modulo_model.php */
