<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Rol_usuario_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Rol_usuario extends ResourceController
{
    protected $format = 'json';

    protected $rol_usuario_model;
    protected $catalogo;

    public function __construct()
    {
        $this->rol_usuario_model = new Rol_usuario_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

public function buscar()
{
    $data = ['exito' => 0];

    $rol = $this->rol_usuario_model->findAll();

    if ($rol) {
        $data['exito'] = 1;
        $data['mensaje'] = "Se han encontrado los siguientes roles:";
        $data['reg'] = $rol;
    } else {
        $data['mensaje'] = "No se han encontrado roles.";
    }

    return $this->respond($data);
}

    
    public function asignar_rol($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_rol = $this->catalogo->ver_usuario_rol([
                'usuario_id' => $datos->usuario_id,
                'rol_id' => $datos->rol_id,
                'activo' => 0,
                'uno' => true
            ]);
            
            if ($existe_rol) {
                $id = $existe_rol->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'usuario_id') && verPropiedad($datos, 'rol_id')) {
                
                $rol = new Rol_usuario_model($id);

                if ($rol->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Rol asignado con éxito";
                    $data['reg'] = $this->catalogo->ver_usuario_rol(['id' => $rol->getPK(), 'uno' => true]);
                } else {
                    $data['mensaje'] = $rol->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_rol_usuario($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $rol = new Rol_usuario_model($id);

        if ($rol->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente el rol.";
        } else {
            $data['mensaje'] = $rol->getMensaje();
        }

        return $this->respond($data);
    }
}
