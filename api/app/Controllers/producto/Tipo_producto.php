<?php

namespace App\Controllers\producto;

use App\Models\producto\Tipo_producto_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;

class Tipo_producto extends ResourceController
{
    protected $format = 'json';
    protected $tipo_producto_model;

    public function __construct()
    {
        $this->tipo_producto_model = new Tipo_producto_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->tipo_producto_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, "nombre")) {
                $tipo = $this->tipo_producto_model;

                if ($tipo->existe_tipo($datos)) {
                    $data['mensaje'] = "Ya existe el tipo de producto que intenta guardar.";
                } else {
                    if ($tipo->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                        $data['linea'] = $tipo->buscar(['id' => $tipo->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = "not implement get message";//$tipo->getMensaje();
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
