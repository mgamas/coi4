<?php

namespace App\Controllers\pedido;

use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use App\Models\pedido\Pedido_det_model;
use App\Models\Stock_res\Stock_res_model;

class Detalle extends ResourceController
{
    protected $pedido_det_model;
    protected $stock_res_model;
    protected $format = 'json';

    public function __construct()
    {
        $this->pedido_det_model = new Pedido_det_model();
        $this->stock_res_model = new Stock_res_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
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

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, 'pedido_enc_id') &&
                verPropiedad($datos, 'no_linea') &&
                verPropiedad($datos, 'cantidad') &&
                verPropiedad($datos, 'producto_bodega_id')) {

                $det = new Pedido_det_model($id);

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

    public function guardarDetalle()
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, 'pedido_enc_id') &&
                verPropiedad($datos, 'cantidad') &&
                verPropiedad($datos, 'producto_bodega_id')) {

                $det = new Pedido_det_model();

                $id = $det->ObtenerDetalleExistente(['datos' => $datos]);

                if ($id) {
                    $det = new Pedido_det_model($id);
                    $datos->cantidad += $det->cantidad;
                }

                if (empty($det->no_linea)) {
                    $datos->no_linea = $det->ObtenerUltimaLinea(['pedido' => $datos->pedido_enc_id]) ?? 1;
                } else {
                    $datos->no_linea = $det->no_linea;
                }

                if ($det->guardar($datos)) {
                    $data['exito'] = 1;
                    $termino = empty($id) ? 'agregado' : 'actualizado';
                    $data['mensaje'] = "Producto {$termino} con éxito.";

                    $data['linea'] = $det->_buscar(['id' => $det->getPK(), 'uno' => true]);

                    $res = new Stock_res_model();
                    $datos->pedido_det_id = $det->getPK();
                    $idRes = $res->ObtenerReservaExistente(['datos' => $datos]);
                    $datos->tipo_transaccion_id = 2;
                    $datos->bodega_ubicacion_id_anterior = $datos->bodega_id;
                    $datos->stock_bodega_id = $datos->stock_id;

                    if ($idRes) {
                        $res = new Stock_res_model($idRes);
                    }

                    if ($res->guardar($datos)) {
                        $data['exito'] = 1;
                        $termino = empty($idRes) ? 'agregada' : 'actualizada';
                        $data['mensaje'] = $data['mensaje'] . " Y reserva {$termino} con éxito.";
                    } else {
                        $data['mensaje'] .= " " . $res->getMensaje();
                    }
                } else {
                    $data['mensaje'] = $det->getMensaje();
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

    public function eliminarDetalle($id)
    {
        $data = ['exito' => 0];

        $reserva = new Stock_res_model();

        if ($reserva->EliminarReserva($id)) {

            $det = new Pedido_det_model();

            if ($det->EliminarDetallePedido($id)) {
                $data['exito'] = 1;
                $data['mensaje'] = "Detalle removido con éxito.";
            } else {
                $data['mensaje'] = $det->getMensaje();
            }
        } else {
            $data['mensaje'] = $reserva->getMensaje();
        }

        return $this->respond($data);
    }
}
