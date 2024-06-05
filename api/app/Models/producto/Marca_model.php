<?php

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;
use function App\Helpers\verConsulta;

class Marca_model extends General_model {

	protected $table = 'marca_producto';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['nombre', 'activo'];
	protected $useTimestamps = false;
	
	public $nombre;
	public $activo = 1;

	public function __construct($id = "")
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

	public function existe_marca($args = [])
	{
		if ($this->getPK()) {
			$this->where("id <>", $this->getPK());
		}

		$tmp = $this->where("nombre", $args['nombre'])->findAll();

		if (count($tmp) > 0) {
			return true;
		}

		return false;
	}
}
