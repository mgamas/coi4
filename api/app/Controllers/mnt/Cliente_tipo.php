<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Cliente_tipo_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Cliente_tipo extends ResourceController
{
    protected $format = 'json';

    protected $cliente_tipo_model;
    protected $catalogo;

    public function __construct()
    {
        $this->cliente_tipo_model = new Cliente_tipo_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->cliente_tipo_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre")) {

                $cliente_tipo = new Cliente_tipo_model($id);

                if ($cliente_tipo->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($cliente_tipo->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $cliente_tipo->buscar(['id' => $cliente_tipo->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $cliente_tipo->getMensaje();
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
}
