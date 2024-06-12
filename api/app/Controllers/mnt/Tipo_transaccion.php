<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use App\Models\mnt\Tipo_transaccion_model;

class Tipo_transaccion extends ResourceController
{
    protected $format = 'json';
    protected $tipo_transaccion_model;

    public function __construct()
    {
        $this->tipo_transaccion_model = new Tipo_transaccion_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }
    
    public function buscar()
    {
        $data = [
            'lista'=> $this->tipo_transaccion_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = null)
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() == "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre")) {
                $transaccion = new Tipo_transaccion_model($id);

                if ($transaccion->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($transaccion->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Transacción guardada con éxito." : "Transacción actualizada con éxito.";
                        $data['linea'] = $transaccion->buscar([
                            'id' => $transaccion->getPK(),
                            'uno' => true
                        ]);
                    } else {
                        $data['mensaje'] = $transaccion->getMensaje();
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
