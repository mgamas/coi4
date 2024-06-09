<?php

namespace App\Models\producto;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Estado_model extends General_model {

    protected $table = 'estado_producto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'utilizable', 'danado', 'activo'];

    public $nombre;
    public $utilizable = 1;
    public $danado = 0;
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

    public function existe_estado($args = [])
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

/* End of file Estado_model.php */
/* Location: ./application/models/Estado_model.php */
