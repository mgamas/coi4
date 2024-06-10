<?php

namespace App\Controllers\bodega;

use CodeIgniter\RESTful\ResourceController;
use App\Models\bodega\Area_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Area extends ResourceController {

	protected $Area_model;
	protected $catalogo_model;
    protected $format = 'json';

	public function __construct()
	{
		$this->Area_model = new Area_model();
		$this->catalogo_model = new \App\Models\catalogo_model();
	}

	public function index()
	{
		return $this->respond(['status' => 404], 404);
	}

	public function buscar()
	{
		$data = [
			'lista' => $this->Area_model->_buscar($this->request->getGet())
		];

		return $this->respond($data);
	}

	public function guardar($id = null) 
	{
		$data = ["exito" => 0];

		if ($this->request->getMethod() === "post") {
			$datos = $this->request->getJSON();

			if (verPropiedad($datos, "codigo") && verPropiedad($datos, "descripcion")) {

				$area = new Area_model($id);

				if ($area->guardar($datos)) {
					$data['exito'] = 1;
					$data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

					$data['linea'] = $area->_buscar([
						'id' => $area->getPK(), 
						'uno' => true
					]);

				} else {
					$data['mensaje'] = $area->getMensaje();
				}
				
			} else {
				$data['mensaje'] = "Complete todos los campos marcados con *.";
			}
		} else {
			$data['mensaje'] = "Error en el envio de datos";
		}

		return $this->respond($data);
	}
}
