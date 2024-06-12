<?php

namespace App\Controllers\mnt;

use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Cliente_sucursal_model;
use App\Models\catalogo_model;

class Cliente_sucursal extends ResourceController
{
    protected $format = 'json';

    protected $cliente_sucursal_model;
    protected $catalogo;

    public function __construct()
    {
        $this->cliente_sucursal_model = new Cliente_sucursal_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = ['exito' => 0];
    
        $items = $this->cliente_sucursal_model->findAll();
    
        if ($items) {
            $data['exito'] = 1;
            $data['items'] = $items;
        } else {
            $data['mensaje'] = "No se encontraron registros.";
        }
    
        return $this->respond($data);
    }


    public function asignar_cliente_sucursal($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_sucursal = $this->catalogo->ver_cliente_sucursal([
                'cliente_id' => $datos->cliente_id, 
                'sucursal_id' => $datos->sucursal_id, 
                'activo' => 0, 
                'uno' => true
            ]);
            
            if ($existe_sucursal) {
                $id = $existe_sucursal->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'cliente_id') && 
                verPropiedad($datos, 'sucursal_id')) {
                
                $clsucursal = new Cliente_sucursal_model($id);

                if ($clsucursal->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                    $data['reg'] = $this->catalogo->ver_cliente_sucursal([
                        'id' => $clsucursal->getPK(), 
                        'uno' => true
                    ]);
                } else {
                    $data['mensaje'] = $clsucursal->getMensaje();
                }
            }
        } 

        return $this->respond($data);
    }

    public function anular_cliente_sucursal($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $sucursal = new Cliente_sucursal_model($id);

        if ($sucursal->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                
        } else {
            $data['mensaje'] = $sucursal->getMensaje();
        }

        return $this->respond($data);
    }
}
