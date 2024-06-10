<?php

namespace App\Controllers\orden;

use CodeIgniter\RESTful\ResourceController;
use App\Models\orden\OrdenCompra_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class OrdenCompra extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new OrdenCompra_model();
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

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "no_documento") && verPropiedad($datos, "observacion")) {

                if($datos->motivo_devolucion_id == 'null' || $datos->motivo_devolucion_id == '' || $datos->motivo_devolucion_id == 'NULL'){
                    $datos->motivo_devolucion_id = null;
                }

                $ordenCompra = new OrdenCompra_model($id);

                if ($ordenCompra->existe($datos)) {
                    $data['mensaje'] = "Ya existe la orden que intenta guardar.";
                } else {

                    if ($ordenCompra->guardar($datos)) {
                        $data['exito']   = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea']   = $ordenCompra->buscar(['id' => $ordenCompra->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $ordenCompra->getMensaje();
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
}
