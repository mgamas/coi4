<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Unidad_medida_model extends General_model
{
    protected $table = 'unidad_medida';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'activo'];

    public $nombre;
    public $activo = 1;

    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function buscar($args = [])
    {
        if (elemento($args, 'id')) {
            $this->where('id', $args['id']);
        }

        if (isset($args['activo'])) {
            $this->where('activo', $args['activo']);
        } else {
            $this->where('activo', 1);
        }

        $tmp = $this->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe_um($args = [])
    {
        if ($this->getPK()) {
            $this->where("id <>", $this->getPK());
        }

        $this->where("nombre", $args['nombre']);
        $tmp = $this->findAll();

        if (count($tmp) > 0) {
            return true;
        }

        return false;
    }
}

/* End of file Unidad_medida_model.php */
/* Location: ./app/Models/Unidad_medida_model.php */
