<?php 

namespace App\Controllers\producto;

use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Models\producto\Estado_model;

class Estado extends ResourceController 
{
	protected $format = 'json';

	public function __construct()
	{
		$this->model = new Estado_model();
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
				$estado = new Estado_model($id);

				if ($estado->existe_estado($datos)) {
					$data['mensaje'] = "Ya existe el estado producto que intenta guardar.";
				} else {
					if ($estado->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

						$data['linea'] = $estado->buscar(['id' => $estado->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $estado->getMensaje();
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
