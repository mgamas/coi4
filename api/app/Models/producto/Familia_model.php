<?php

namespace App\Models\producto;

use App\Models\General_model;
use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Familia_model extends General_model {

    protected $table = 'familia_producto';
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

        $tmp = $db->table($this->table)->get();

        return verConsulta($tmp, $args);
    }

    public function existe_fam($args = [])
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

/* End of file Familia_model.php */
/* Location: ./application/models/Familia_model.php */
