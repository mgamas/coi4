<?php 

namespace App\Controllers\producto;

use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Models\producto\Familia_model;

class Familia extends ResourceController 
{
	protected $format = 'json';

	public function __construct()
	{
		$this->model = new Familia_model();
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
				$fam = new Familia_model($id);

				if ($fam->existe_fam($datos)) {
					$data['mensaje'] = "Ya existe la familia que intenta guardar.";
				} else {
					if ($fam->guardar($datos)) {
						$data['exito'] = 1;
						$data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

						$data['linea'] = $fam->buscar(['id' => $fam->getPK(), 'uno' => true]);
					} else {
						$data['mensaje'] = $fam->getMensaje();
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
