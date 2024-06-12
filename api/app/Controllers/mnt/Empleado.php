<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Empleado_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Empleado extends ResourceController
{
    protected $format = 'json';

    protected $empleado_model;
    protected $catalogo;

    public function __construct()
    {
        $this->empleado_model = new Empleado_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->empleado_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ["exito" => 0];
        
        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre") && 
                verPropiedad($datos, "apellido")) {

                $empleado = new Empleado_model($id);

                if ($empleado->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($empleado->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Empleado guardado con éxito." : "Empleado actualizado con éxito.";
                        $data['linea'] = $empleado->buscar([
                            'id' => $empleado->getPK(),
                            'uno' => true
                        ]);
                    } else {
                        $data['mensaje'] = $empleado->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos.";
        }

        return $this->respond($data);
    }

    public function anular_empleado($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $empleado = new Empleado_model($id);

        if ($empleado->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Empleado anulado con éxito.";
        } else {
            $data['mensaje'] = $empleado->getMensaje();
        }

        return $this->respond($data);
    }
}
