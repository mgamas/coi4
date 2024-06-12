<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use App\Models\mnt\Vehiculos_model;

class Vehiculos extends ResourceController
{
    protected $format = 'json';
    protected $vehiculos_model;
    protected $user;

    public function __construct()
    {
        $this->vehiculos_model = new Vehiculos_model();
        $this->session = session();
        $this->user = $this->session->get('usuario');
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->vehiculos_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = null)
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "tipo") && verPropiedad($datos, "placa")) {
                $Vehiculos = new Vehiculos_model($id);

                if (empty($id)) {
                    $datos->usuario_agr = $this->user['id'];
                    $datos->fecha_agr = Hoy(true);
                }

                if ($Vehiculos->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($Vehiculos->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $Vehiculos->buscar(['id' => $Vehiculos->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $Vehiculos->getMensaje();
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
