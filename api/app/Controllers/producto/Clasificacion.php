<?php 

namespace App\Controllers\producto;

use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Models\producto\Clasificacion_model;

class Clasificacion extends ResourceController 
{
	protected $format = 'json';

	public function __construct()
	{
		$this->model = new Clasificacion_model();
	}

	public function index()
	{
		return $this->response->setStatusCode(404);
	}

	public function buscar() 
	{
		$data = [
			'lista' => $this->model->buscar($this->request->getGet())
		];

		return $this->respond($data);
	}

	public function guardar($id = null) 
	{
		$data = ["exito" => 0];

		if ($this->request->getMethod() === "post") {
			$datos = $this->request->getJSON();

			if (verPropiedad($datos, "nombre")) {
				$clas = new Clasificacion_model($id);

				if ($clas->existe_clas($datos)) {
					$data['mensaje'] = "Ya existe la clasificación que esta intentado guardar.";
				} else {
					if ($clas->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

						$data['linea'] = $clas->buscar(['id' => $clas->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $clas->getMensaje();
					}
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
