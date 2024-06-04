<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Tipo_producto_model extends General_model
{
    protected $table = 'tipo_producto'; // Nombre de la tabla
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

    public function existe_tipo($args = [])
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

/* End of file Tipo_producto_model.php */
/* Location: ./app/Models/Tipo_producto_model.php */
