<?php

namespace App\Controllers\mnt;

use App\Models\mnt\Cliente_direccion_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Cliente_direccion extends ResourceController
{
    protected $clienteDireccionModel;
    protected $format = 'json';

    public function __construct()
    {
        $this->clienteDireccionModel = new Cliente_direccion_model();
        $this->catalogoModel = new \App\Models\Catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('Recurso no encontrado');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->clienteDireccionModel->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = null)
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = $this->request->getJSON();
            
            if (verPropiedad($datos, "direccion") &&
                verPropiedad($datos, "cliente_id")) {

                $direccion = new Cliente_direccion_model($id);

                if ($direccion->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                    $data['linea'] = $direccion->_buscar([
                        'id' => $direccion->getPK(), 
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $direccion->getMensaje();
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
