<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use App\Models\mnt\Usuario_sucursal_model;
use App\Models\Catalogo_model;

class Usuario_sucursal extends ResourceController
{
    protected $format = 'json';
    protected $usuario_sucursal_model;
    protected $catalogo;

    public function __construct()
    {
        $this->usuario_sucursal_model = new Usuario_sucursal_model();
        $this->catalogo = new Catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = ['exito' => 0];
    
        $usuarios_sucursales = $this->usuario_sucursal_model->findAll();
    
        if ($usuarios_sucursales) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se han encontrado los siguientes usuarios y sucursales:";
            $data['reg'] = $usuarios_sucursales;
        } else {
            $data['mensaje'] = "No se encontraron usuarios y sucursales.";
        }
    
        return $this->respond($data);
    }
    

    public function asignar_sucursal($id = null)
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = json_decode($this->request->getBody());

            $existe_suc = $this->catalogo->ver_usuario_sucursal([
                'usuario_id'  => $datos->usuario_id,
                'sucursal_id' => $datos->sucursal_id,
                'activo'      => 0,
                'uno'         => true
            ]);

            if ($existe_suc) {
                $id = $existe_suc->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'usuario_id') && verPropiedad($datos, 'sucursal_id')) {
                $sucursal = new Usuario_sucursal_model($id);

                if ($sucursal->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Sucursal asignada con éxito";
                    $data['reg'] = $this->catalogo->ver_usuario_sucursal([
                        'id' => $sucursal->getPK(),
                        'uno' => true
                    ]);
                } else {
                    $data['mensaje'] = $sucursal->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_sucursal($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $sucursal = new Usuario_sucursal_model($id);

        if ($sucursal->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente la sucursal.";
        } else {
            $data['mensaje'] = $sucursal->getMensaje();
        }

        return $this->respond($data);
    }
}
