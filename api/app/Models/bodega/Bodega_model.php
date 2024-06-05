<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Bodega_model extends General_model {

    protected $table = 'bodega';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'correo',
        'encargado',
        'largo',
        'ancho',
        'alto',
        'activo',
        'empresa_id'
    ];

    public $codigo;
    public $nombre;
    public $direccion = null;
    public $telefono = null;
    public $correo = null;
    public $encargado = null;
    public $largo = null;
    public $ancho = null;
    public $alto = null;
    public $activo = 1;
    public $empresa_id;

    public function __construct($id = "")
    {
        parent::__construct();
        $this->setTabla($this->table);
        $this->setLlave($this->primaryKey);

        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function existe($args = [])
    {
        $db = \Config\Database::connect();

        if ($this->getPK()) {
            $db->table($this->table)->where("id <>", $this->getPK());
        }

        $tmp = $db->table($this->table)
            ->where("codigo", $args->codigo)
            ->where("nombre", $args->nombre)
            ->where("empresa_id", $args->empresa_id)
            ->where("activo", 1)
            ->get();

        return $tmp->getNumRows() > 0;
    }

    public function _buscar($args = [])
    {
        $db = \Config\Database::connect();

        if (elemento($args, 'id')) {
            $db->table($this->table)->where("a.id", $args['id']);
        }

        if (isset($args['activo'])) {
            $db->table($this->table)->where('a.activo', $args['activo']);
        } else {
            $db->table($this->table)->where('a.activo', 1);
        }

        $tmp = $db->table($this->table . ' a')
            ->select("a.*, b.nombre as nempresa")
            ->join("empresa b", "b.id = a.empresa_id")
            ->get();

        return verConsulta($tmp, $args);
    }
}

/* End of file Bodega_model.php */
/* Location: ./application/models/Bodega_model.php */
