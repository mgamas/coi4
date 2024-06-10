<?php

namespace App\Controllers\mnt;

use App\Models\mnt\Cliente_contacto_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Cliente_contacto extends ResourceController
{
    protected $format = 'json';

    protected $clienteContactoModel;

    public function __construct()
    {
        $this->clienteContactoModel = new Cliente_contacto_model();
    }

    public function index()
    {
        return $this->failNotFound('Recurso no encontrado');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->clienteContactoModel->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, "nombre") && verPropiedad($datos, "telefono")) {
                $contacto = new Cliente_contacto_model($id);

                if ($contacto->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                    $data['linea'] = $contacto->_buscar([
                        'id' => $contacto->getPK(),
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $contacto->getMensaje();
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
