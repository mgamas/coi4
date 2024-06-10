<?php

namespace App\Controllers\orden;

use CodeIgniter\RESTful\ResourceController;
use App\Models\orden\OrdenCompraDetalle_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class OrdenCompraDetalle extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new OrdenCompraDetalle_model();
    }

    public function index()
    {
        return $this->failNotFound('404 - Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function getLast()
    {
        $data = [
            'lista' => $this->model->getLast($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, 'no_linea')) {
                $ordenCompraDetalle = new OrdenCompraDetalle_model($id);

                if ($ordenCompraDetalle->existe($datos)) {
                    $data['exito'] = 2;
                    $data['mensaje'] = "Ya existe el detalle de la orden que intenta guardar.";
                } else {
                    if ($ordenCompraDetalle->guardar($datos)) {
                        $data['exito']   = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                        if (empty($id)) {
                            $data['linea'] = $ordenCompraDetalle->getLast(['orden_compra_enc_id' => $datos->orden_compra_enc_id, 'uno' => true]);
                        } else {
                            $data['linea'] = $ordenCompraDetalle->buscar(['id' => $ordenCompraDetalle->getPK(), 'uno' => true]);
                        }
                    } else {
                        $data['mensaje'] = $ordenCompraDetalle->getMensaje();
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

    public function eliminar_producto($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $det = new OrdenCompraDetalle_model($id);

        if ($det->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Producto removido con éxito.";
        } else {
            $data['mensaje'] = $det->getMensaje();
        }

        return $this->respond($data);
    }

    public function actualizar_linea($id)
    {
        $data = ['exito' => 0];

        $det = new OrdenCompraDetalle_model($id);
        $datos = ['no_linea' => $det->no_linea - 1];

        if ($det->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Número de línea actualizado con éxito.";
        } else {
            $data['mensaje'] = $det->getMensaje();
        }

        return $this->respond($data);
    }
}
