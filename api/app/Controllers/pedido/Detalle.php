<?php

namespace App\Controllers\pedido;

use App\Models\pedido\Pedido_det_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;

class Detalle extends ResourceController
{
    protected $format = 'json';
    protected $pedido_det_model;

    public function __construct()
    {
        $this->pedido_det_model = new Pedido_det_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->pedido_det_model->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'pedido_enc_id') &&
                verPropiedad($datos, 'no_linea') &&
                verPropiedad($datos, 'cantidad') &&
                verPropiedad($datos, 'producto_bodega_id')) {

                $det = $this->pedido_det_model;

                if (empty($id)) {
                    $det->setNoLinea(['pedido' => $datos->pedido_enc_id]);
                }

                if ($det->existe($datos)) {
                    $data['exito'] = 2;
                    $data['mensaje'] = "El producto ya se encuentra agregado a este pedido.";
                } else {
                    if ($det->guardar($datos)) {
                        $data['exito'] = 1;
                        $termino = empty($id) ? 'agregado' : 'actualizado';
                        $data['mensaje'] = "Producto {$termino} con éxito.";

                        $data['linea'] = $det->_buscar(['id' => $det->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $det->getMensaje();
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

        $det = new Pedido_det_model($id);

        if ($det->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Producto removido con éxito.";
        } else {
            $data['mensaje'] = $det->getMensaje();
        }

        return $this->respond($data);
    }
}
