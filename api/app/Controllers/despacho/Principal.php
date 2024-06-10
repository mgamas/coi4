<?php

namespace App\Controllers\despacho;

use App\Models\Catalogo_model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\despacho\Despacho_model;
use App\Models\despacho\Despacho_det_model;
use App\Models\stock\Stock_model;
use App\Models\stock_res\Stock_res_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Principal extends ResourceController
{
    protected $Despacho_model;
    protected $Despacho_det_model;
    protected $Stock_model;
    protected $Stock_res_model;
    protected $catalogo;
    protected $format = 'json';
    protected $user;

    public function __construct()
    {
        $this->Despacho_model = new Despacho_model();
        $this->Despacho_det_model = new Despacho_det_model();
        $this->Stock_model = new Stock_model();
        $this->Stock_res_model = new Stock_res_model();
        $this->catalogo = new Catalogo_model();
        $this->user = session()->get('usuario');
    }

    public function index()
    {
        return $this->failNotFound();
    }

    public function buscar() 
    {
        $data = [
            'lista' => $this->Despacho_model->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function get_datos() 
    {
        $data = [
            'cat' => [
                'productos'   => $this->catalogo->ver_productos_bodega(),
                'transaccion' => $this->catalogo->ver_tipo_transaccion(),
                'bodega'      => $this->catalogo->ver_bodega(),
                'vehiculo'    => $this->catalogo->ver_vehiculos(),
                'piloto'      => $this->catalogo->ver_pilotos(),
                'ruta'        => $this->catalogo->ver_ruta(),
                'presentacion'=> $this->catalogo->ver_presentacion(),
                'estado_prod' => $this->catalogo->ver_estado(),
                'um'          => $this->catalogo->ver_um(),
                'fecha'       => Hoy(),
            ]
        ];

        return $this->respond($data);
    }

    public function guardar($id = '') 
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "bodega_id") && verPropiedad($datos, "tipo_transaccion_id")) {

                $rec = new Despacho_model($id);
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
                    $data['mensaje'] = empty($id) ? "Despacho guardado con éxito." : "Despacho actualizado.";
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
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->respond($data);
    }

    public function despachar() 
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "detalle")) {

                $ubic = $this->catalogo->ver_ubicacion([
                    "bodega_id" => $datos->bodega,
                    "ubicacion_despacho" => 1,
                    "uno" => true
                ]);

                $realizados = 0;
                if ($ubic) {
                    foreach($datos->detalle as $row) {
                        $row->despacho_enc_id = $row->id;
                        $row->bodega_ubicacion_id = $ubic->id;

                        $stock = new Stock_model();
                        $stock->guardar($row);
                        $realizados++;
                    }

                    if ($realizados > 0) {
                        $ddespacho = [
                            "estado" => 'Finalizado'
                        ];

                        $rec = new Despacho_model($datos->detalle[0]->despacho_enc_id);
                        $rec->guardar($ddespacho);

                        $data["exito"] = 1;
                        $data["mensaje"] = "Despacho realizado con éxito.";
                        $data["despacho"] = $rec->_buscar(["id" => $rec->getPK(), "uno" => true]);
                    }
                } else {
                    $data["mensaje"] = "No se tiene una ubicación de recepción";
                }
            }
        } else {
            $data["mensaje"] = "Método de envío incorrecto";
        }

        return $this->respond($data);
    }
}
