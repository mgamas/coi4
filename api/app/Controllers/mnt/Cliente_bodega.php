<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Cliente_bodega_model;
use App\Models\Catalogo_model;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;

class Cliente_bodega extends ResourceController
{
    protected $clienteBodegaModel;
    protected $catalogo;
    protected $format = 'json';

    public function __construct()
    {
        $this->clienteBodegaModel = new Cliente_bodega_model();
        $this->catalogo = new Catalogo_model();
    }

    public function index()
    {
        $data = $this->clienteBodegaModel->findAll();
        return $this->respond($data);

    }

    public function asignar_cliente_bodega($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            $existe_bodega = $this->catalogo->ver_cliente_bodega([
                'cliente_id' => $datos->cliente_id,
                'bodega_id' => $datos->bodega_id,
                'activo' => 0,
                'uno' => true
            ]);

            if ($existe_bodega) {
                $id = $existe_bodega->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'cliente_id') && verPropiedad($datos, 'bodega_id')) {
                $clbodega = new Cliente_bodega_model();

                if ($clbodega->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Bodega asignada con éxito";
                    $data['reg'] = $this->catalogo->ver_cliente_bodega([
                        'id' => $clbodega->getPK(),
                        'uno' => true
                    ]);
                } else {
                    $data['mensaje'] = $clbodega->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_cliente_bodega($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $bodega = new Cliente_bodega_model();

        if ($bodega->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente la bodega.";
        } else {
            $data['mensaje'] = $bodega->getMensaje();
        }

        return $this->respond($data);
    }
}
