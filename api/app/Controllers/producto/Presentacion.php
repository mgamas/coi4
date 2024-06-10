<?php

namespace App\Controllers\producto;

use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Models\producto\Presentacion_model;

class Presentacion extends ResourceController
{
    public function __construct()
    {
        $this->model = new Presentacion_model();
        $this->format = 'json';
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

            if (verPropiedad($datos, "codigo") &&
                verPropiedad($datos, "nombre") &&
                verPropiedad($datos, "factor")) {

                $pres = new Presentacion_model($id);

                if ($pres->existe($datos)) {
                    $data['mensaje'] = "Ya existe la presentación que intenta guardar.";
                } else {
                    if ($pres->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito" : "Registro actualizado";

                        $data['linea'] = $pres->buscar(['id' => $pres->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $pres->getMensaje();
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
