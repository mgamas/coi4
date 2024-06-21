<?php

namespace App\Controllers\reserva;

use App\Models\stock_res\Stock_res_model;
use App\Models\Catalogo_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Principal extends ResourceController
{
    protected $format = 'json';
    protected $stock_res_model;
    protected $catalogo_model;
    protected $user;

    public function __construct()
    {
        $this->stock_res_model = new Stock_res_model();
        $this->catalogo_model = new Catalogo_model();
        $this->user = session()->get('usuario');
    }

    public function index()
    {
        return $this->failNotFound();
    }

    public function guardar($id = null)
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, "pedido_enc_id") &&
                verPropiedad($datos, "tipo_transaccion_id") &&
                verPropiedad($datos, "pedido_det_id") &&
                verPropiedad($datos, "stock_bodega_id") &&
                verPropiedad($datos, "producto_bodega_id") &&
                verPropiedad($datos, "estado_producto_id") &&
                verPropiedad($datos, "presentacion_producto_id") &&
                verPropiedad($datos, "unidad_medida_id") &&
                verPropiedad($datos, "bodega_ubicacion_id") &&
                verPropiedad($datos, "pedido_det_id") &&
                verPropiedad($datos, "bodega_id")) {

                $res = new Stock_res_model($id);

                $fecha = Hoy(true);
                $us = $this->user['id'];

                if (empty($id)) {
                    $datos->fecha_agr = $fecha;
                    $datos->usuario_agr = $us;
                }

                $datos->fecha_mod = $fecha;
                $datos->usuario_mod = $us;

                if ($res->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Despacho guardado con éxito." : "Despacho actualizado.";
                    $data['linea'] = $res->buscar([
                        'id' => $res->getPK(),
                        'uno' => true
                    ]);
                } else {
                    $data['mensaje'] = $res->getMensaje();
                }
            } else {
                $data['mensaje'] = "No se completaron los campos obligatorios, por favor verificar.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos.";
        }

        return $this->respond($data);
    }
}
