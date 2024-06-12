<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Motivo_anulacion_pedido_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Motivo_anulacion_pedido extends ResourceController
{
    protected $format = 'json';

    protected $motivo_anulacion_pedido_model;
    protected $catalogo;

    public function __construct()
    {
        $this->motivo_anulacion_pedido_model = new Motivo_anulacion_pedido_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->motivo_anulacion_pedido_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre")) {

                $mt_anulacion_pedido = new Motivo_anulacion_pedido_model($id);

                if ($mt_anulacion_pedido->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {

                    if ($mt_anulacion_pedido->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $mt_anulacion_pedido->buscar(['id' => $mt_anulacion_pedido->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $mt_anulacion_pedido->getMensaje();
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
