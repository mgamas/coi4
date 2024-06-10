<?php

namespace App\Controllers\producto;

use App\Models\producto\Producto_Bodega_Model;
use App\Models\Catalogo_Model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use App\Helpers\Hoy;

class Producto_bodega extends ResourceController
{
    protected $catalogo;

    public function __construct()
    {   
        $this->model = new Producto_Bodega_Model();
        $this->catalogo = new Catalogo_Model();
        $this->format = 'json';
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function asignar_producto_bodega($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            $existe_producto = $this->catalogo->ver_producto_bodega([
                'producto_id' => $datos->producto_id, 
                'bodega_id'   => $datos->bodega_id, 
                'activo'      => 0, 
                'uno'         => true
            ]);

            if ($existe_producto) {
                $id = $existe_producto->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'producto_id') && verPropiedad($datos, 'bodega_id')) {
                $pvbodega = new Producto_Bodega_Model($id);

                if ($pvbodega->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Bodega asignada con éxito";
                    $data['reg'] = $this->catalogo->ver_producto_bodega([
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

    public function anular_producto_bodega($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $bodega = new Producto_Bodega_Model($id);

        if ($bodega->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente la bodega.";
        } else {
            $data['mensaje'] = $bodega->getMensaje();
        }

        return $this->respond($data);
    }

    public function buscar()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }
}
