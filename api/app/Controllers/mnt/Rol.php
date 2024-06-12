<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Rol_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Rol extends ResourceController
{
    protected $format = 'json';

    protected $rol_model;
    protected $catalogo;

    public function __construct($id = '')
    {
        $this->rol_model = new Rol_model();
        $this->catalogo = new catalogo_model();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->rol_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function anular_rol($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $rol = new Rol_model($id);

        if ($rol->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Rol anulado con éxito.";
        } else {
            $data['mensaje'] = $rol->getMensaje();
        }

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'nombre')) {
                $rol = new Rol_model($id);

                if ($rol->existe_rol(['nombre' => $datos->nombre])) {
                    $data['mensaje'] = "Este nombre de rol ya está registrado.";
                } else {
                    if ($rol->guardar($datos)) {
                        $data['exito'] = 1;
                        $termino = empty($id) ? 'guardado' : 'actualizado';
                        $data['mensaje'] = "Rol {$termino} con éxito";
                        $data['linea'] = $rol->buscar(['id' => $rol->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $rol->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Método de envío incorrecto";
        }

        return $this->respond($data);
    }
}
