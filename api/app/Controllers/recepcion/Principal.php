<?php

namespace App\Controllers\recepcion;

use App\Models\recepcion\Recepcion_model;
use App\Models\recepcion\Recepcion_det_model;
use App\Models\stock\Stock_model;
use App\Models\Movimiento_model;
use App\Models\producto\Presentacion_model;
use App\Models\Catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use CodeIgniter\RESTful\ResourceController;

class Principal extends ResourceController
{
    protected $user;
    protected $recepcionModel;
    protected $recepcionDetModel;
    protected $stockModel;
    protected $movimientoModel;
    protected $presentacionModel;
    protected $catalogoModel;

    public function __construct()
    {
        $this->user = session()->get('usuario');
        $this->recepcionModel = new Recepcion_model();
        $this->recepcionDetModel = new Recepcion_det_model();
        $this->stockModel = new Stock_model();
        $this->movimientoModel = new Movimiento_model();
        $this->presentacionModel = new Presentacion_model();
        $this->catalogoModel = new Catalogo_model();
    }

    public function index()
    {
        return $this->respond(null, 404);
    }

    public function buscar() 
    {
        $data = [
            'lista' => $this->recepcionModel->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function get_datos() 
    {
        $data = [
            'cat' => [
                'productos'   => $this->catalogoModel->ver_productos_bodega(),
                'estado'      => $this->catalogoModel->ver_estado_rec(),
                'transaccion' => $this->catalogoModel->ver_tipo_transaccion(),
                'bodega'      => $this->catalogoModel->ver_bodega(),
                'vehiculo'    => $this->catalogoModel->ver_vehiculos(),
                'piloto'      => $this->catalogoModel->ver_pilotos(),
                'presentacion'=> $this->catalogoModel->ver_presentacion(),
                'estado_prod' => $this->catalogoModel->ver_estado(),
                'um'          => $this->catalogoModel->ver_um(),
                'fecha'       => Hoy(),
            ]
        ];

        return $this->respond($data);
    }

    public function guardar($id = null) 
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "bodega_id") &&
                verPropiedad($datos, "tipo_transaccion_id") &&
                verPropiedad($datos, "estado_recepcion_id")) {

                $rec = new Recepcion_model($id);

                $fecha = Hoy(true);
                $us = $this->user['id'];

                if (empty($id)) {
                    $datos->fecha_agr = $fecha;
                    $datos->usuario_agr = $us;
                }

                $datos->fecha_mod = $fecha;
                $datos->usuario_mod =  $us;

                if ($rec->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Recepción guardada con éxito." : "Recepción actualizada.";

                    $data['linea'] = $rec->_buscar([
                        'id' => $rec->getPK(), 
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $rec->getMensaje();
                }
                
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['menasje'] = "Error en el envio de datos";
        }

        return $this->respond($data);
    }

    public function recibir() 
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "detalle")) {

                $ubic = $this->catalogoModel->ver_ubicacion([
                    "bodega_id" => $datos->bodega,
                    "ubicacion_recepcion" => 1,
                    "uno" => true
                ]);

                $realizados = 0;
                if ($ubic) {
                    foreach($datos->detalle as $row) {

                        if (!empty($row->presentacion_producto_id)) {
                            $pres = $this->presentacionModel->buscar([
                                'id' => $row->presentacion_producto_id, 
                                'uno' => true
                            ]);

                            if ($pres) {
                                $row->cantidad = $pres->factor * $row->cantidad_recibida;
                            }
                        } else {
                            $row->cantidad  = $row->cantidad_recibida;
                        }

                        $row->bodega_id = $datos->bodega;
                        $row->bodega_ubicacion_id = $ubic->id;
                        $row->recepcion_det_id = $row->id;
                        $row->bodega_ubicacion_id_anterior = $ubic->id;

                        $this->stockModel->guardar($row);

                        $row->fechaVence = $row->fecha_vence;
                        $row->cantHist = $row->cantidad;
                        $row->pesoHist = $row->peso;
                        $row->fechaOperacion = Hoy(true);
                        $row->usuario_agr = $this->user['id'];
                        $row->empresa_id =  $this->user['empresa_id'];
                        $row->bodega_ubicacion_id_origen = $row->bodega_ubicacion_id;
                        $row->bodega_ubicacion_id_destino = $row->bodega_ubicacion_id;
                        $row->bodega_id_origen = $datos->bodega;
                        $row->bodega_id_destino = $datos->bodega;
                        $row->estado_producto_id_origen = $row->estado_producto_id;
                        $row->estado_producto_id_destino = $row->estado_producto_id;
                        $row->recepcion_enc_id = $datos->rec;
                        $row->tipo_transaccion_id = $datos->transaccion;

                        $this->movimientoModel->guardar($row);
                        $realizados++;
                    }

                    if ($realizados > 0) {
                        $drecepcion = [
                            "estado_recepcion_id" => 6
                        ];

                        $rec = new Recepcion_model($datos->detalle[0]->recepcion_enc_id);
                        $rec->guardar($drecepcion);

                        $data["exito"] = 1;
                        $data["mensaje"] = "Recepción realizada con éxito.";
                        $data["recepcion"] = $rec->_buscar(["id" => $rec->getPK(), "uno" => true]);
                    }

                } else {
                    $data["mensaje"] = "No se tiene una ubicación de recepción";
                }
            } else {
                $data["mensaje"] = "No tiene productos que recibir";
            }
        } else {
            $data["mensaje"] = "Metodo de envio incorrecto";
        }

        return $this->respond($data);
    }
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */
