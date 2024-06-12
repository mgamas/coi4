<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Modulo_rol_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Modulo_rol extends ResourceController
{
    protected $format = 'json';

    protected $modulo_rol_model;
    protected $catalogo;

    public function __construct()
    {
        $this->modulo_rol_model = new Modulo_rol_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

public function buscar()
{
    $data = ['exito' => 0];

    $modulos_rol = $this->modulo_rol_model->findAll();

    if ($modulos_rol) {
        $data['exito'] = 1;
        $data['mensaje'] = "Se han encontrado los siguientes módulos de rol:";
        $data['reg'] = $modulos_rol;
    } else {
        $data['mensaje'] = "No se han encontrado módulos de rol.";
    }

    return $this->respond($data);
}


    public function asignar_modulo($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_modulo = $this->catalogo->ver_modulo_rol([
                'modulo_id' => $datos->modulo_id,
                'rol_id' => $datos->rol_id,
                'activo' => 0,
                'uno' => true
            ]);

            if ($existe_modulo) {
                $id = $existe_modulo->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'modulo_id') && verPropiedad($datos, 'rol_id')) {
                
                $modulo_rol = new Modulo_rol_model($id);

                if ($modulo_rol->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Modulo asignado con éxito";
                    $data['reg'] = $this->catalogo->ver_rol_modulo([
                        'rol_id' => $datos->rol_id,
                        'modulo_id' => $datos->modulo_id
                    ]);
                } else {
                    $data['mensaje'] = $modulo_rol->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_modulo_rol($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $modulo_rol = new Modulo_rol_model($id);

        if ($modulo_rol->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente el modulo.";
        } else {
            $data['mensaje'] = $modulo_rol->getMensaje();
        }

        return $this->respond($data);
    }
}
