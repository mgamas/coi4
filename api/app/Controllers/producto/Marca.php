<?php

namespace App\Controllers\producto;

use function App\Helpers\verPropiedad;
use App\Models\producto\Marca_model;
use CodeIgniter\RESTful\ResourceController;

class Marca extends ResourceController
{
    public function __construct()
    {
        $this->format = 'json';
        $this->model = new Marca_model();
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

        return $this->response->setJSON($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, "nombre")) {
                $marca = new Marca_model($id);

                if ($marca->existe_marca($datos)) {
                    $data['mensaje'] = "Ya existe la marca que está intentando guardar.";
                } else {
                    if ($marca->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                        $data['linea'] = $marca->buscar(['id' => $marca->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $marca->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->response->setJSON($data);
    }
}
