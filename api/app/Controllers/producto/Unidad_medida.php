<?php

namespace App\Controllers\producto;

use App\Models\producto\Unidad_medida_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;

class Unidad_medida extends ResourceController
{
    protected $format = 'json';
    protected $unidad_medida_model;

    public function __construct()
    {
        $this->unidad_medida_model = new Unidad_medida_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->unidad_medida_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, "nombre")) {
                $um = $this->unidad_medida_model;

                if ($um->existe_um($datos)) {
                    $data['mensaje'] = "Ya la unidad de medida que intenta guardar.";
                } else {
                    if ($um->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito" : "Registro actualizado";

                        $data['linea'] = $um->buscar(['id' => $um->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $um->getMensaje();
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
