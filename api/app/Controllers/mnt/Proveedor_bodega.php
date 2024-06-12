<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Proveedor_bodega_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Proveedor_bodega extends ResourceController
{
    protected $format = 'json';

    protected $proveedor_bodega_model;
    protected $catalogo;

    public function __construct()
    {
        $this->proveedor_bodega_model = new Proveedor_bodega_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

public function buscar()
{
    $data = ['exito' => 0];

    $proveedor_bodega = $this->proveedor_bodega_model->findAll();

    if ($proveedor_bodega) {
        $data['exito'] = 1;
        $data['mensaje'] = "Se han encontrado los siguientes registros:";
        $data['registros'] = $proveedor_bodega;
    } else {
        $data['mensaje'] = "No se encontraron registros.";
    }

    return $this->respond($data);
}


    public function asignar_proveedor_bodega($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_proveedor = $this->catalogo->ver_proveedor_bodega([
                'proveedor_id' => $datos->proveedor_id,
                'bodega_id' => $datos->bodega_id,
                'activo' => 0,
                'uno' => true
            ]);
            
            if ($existe_proveedor) {
                $id = $existe_proveedor->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'proveedor_id') && verPropiedad($datos, 'bodega_id')) {
                
                $pvbodega = new Proveedor_bodega_model($id);

                if ($pvbodega->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Bodega asignada con éxito";
                    $data['reg'] = $this->catalogo->ver_proveedor_bodega([
                        'id' => $pvbodega->getPK(),
                        'uno' => true
                    ]);
                } else {
                    $data['mensaje'] = $pvbodega->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_proveedor_bodega($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $bodega = new Proveedor_bodega_model($id);

        if ($bodega->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente la bodega.";
        } else {
            $data['mensaje'] = $bodega->getMensaje();
        }

        return $this->respond($data);
    }
}
