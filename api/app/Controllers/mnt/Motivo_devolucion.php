<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Motivo_devolucion_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Motivo_devolucion extends ResourceController
{
    protected $format = 'json';

    protected $motivo_devolucion_model;
    protected $catalogo;

    public function __construct()
    {
        $this->motivo_devolucion_model = new Motivo_devolucion_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->motivo_devolucion_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre")) {

                $motivo_devolucion = new Motivo_devolucion_model($id);

                if ($motivo_devolucion->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {

                    if ($motivo_devolucion->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $motivo_devolucion->buscar(['id' => $motivo_devolucion->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $motivo_devolucion->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->respond($data);
    }
}
