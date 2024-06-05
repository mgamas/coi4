<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Clasificacion_model extends General_model {

    protected $table = 'clasificacion_producto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'activo'];

    public $nombre;
    public $activo = 1;

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
            $db->table($this->table)->where('id', $args['id']);
        }

        if (isset($args['activo'])) {
            $db->table($this->table)->where('activo', $args['activo']);
        } else {
            $db->table($this->table)->where('activo', 1);
        }

        $tmp = $db->table($this->table)->get();

        return verConsulta($tmp, $args);
    }

    public function existe_clas($args = [])
    {
        $db = \Config\Database::connect();
        
        if ($this->getPK()) {
            $db->table($this->table)->where("id <>", $this->getPK());
        }

        $tmp = $db->table($this->table)
                  ->where("nombre", $args->nombre)
                  ->get();

        if ($tmp->getNumRows() > 0) {
            return true;
        }

        return false;
    }
}

/* End of file Clasificacion_model.php */
/* Location: ./application/models/Clasificacion_model.php */
