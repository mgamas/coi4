<?php

namespace App\Controllers\pedido;

use App\Models\Catalogo_model;
use CodeIgniter\RESTful\ResourceController;
use App\Models\pedido\Pedido_model;
use App\Models\pedido\Pedido_det_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use App\Helpers\elemento;

class Principal extends ResourceController {

    protected $user;
    protected $catalogo;
    protected $pedidoModel;
    protected $pedidoDetModel;
    protected $format = 'json';
    public function __construct()
    {
        $this->pedidoModel = new Pedido_model();
        $this->pedidoDetModel = new Pedido_det_model();
        $this->catalogo = new Catalogo_model();
        $this->user = session()->get('usuario');
    }

    public function index()
    {
        return $this->response->setStatusCode(404);
    }

    public function buscar() 
    {
        $data = [
            'lista' => $this->pedidoModel->_buscar($this->request->getGet())
        ];

        return $this->response->setJSON($data);
    }

    public function get_datos() 
    {
        $data = [
            'cat' => [
                'productos'   => $this->catalogo->ver_productos_bodega(),
                'cliente'     => $this->catalogo->ver_cliente(),
                'transaccion' => $this->catalogo->ver_tipo_transaccion(),
                'bodega'      => $this->catalogo->ver_bodega(),
                'pedido_tipo' => $this->catalogo->ver_pedido_tipo(),
                'motivo_anulacion_pedido' => $this->catalogo->ver_motivo_anulacion_pedido(),
                'presentacion'=> $this->catalogo->ver_presentacion(),
                'estado_prod' => $this->catalogo->ver_estado(),
                'um'          => $this->catalogo->ver_um(),
                'fecha'       => Hoy(),
            ]
        ];

        return $this->response->setJSON($data);
    }

    public function guardar($id = null) 
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "bodega_id") && verPropiedad($datos, "tipo_transaccion_id")) {

                $rec = new Pedido_model($id);

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
                    $data['mensaje'] = empty($id) ? "Pedido guardado con éxito." : "Pedido actualizado.";

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
            $data['mensaje'] = "Error en el envio de datos";
        }

        return $this->response->setJSON($data);
    }
}
