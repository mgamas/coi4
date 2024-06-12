<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Proveedor_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Proveedor extends ResourceController
{
    protected $format = 'json';

    protected $proveedor_model;
    protected $catalogo;

    public function __construct()
    {
        $this->proveedor_model = new Proveedor_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->proveedor_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre") && 
                verPropiedad($datos, "empresa_id")) {

                $proveedor = new Proveedor_model($id);

                if ($proveedor->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($proveedor->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Proveedor guardado con éxito." : "Proveedor actualizado con éxito.";
                        $data['linea'] = $proveedor->buscar([
                            'id' => $proveedor->getPK(),
                            'uno' => true
                        ]);
                    } else {
                        $data['mensaje'] = $proveedor->getMensaje();
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
