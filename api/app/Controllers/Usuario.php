<?php

namespace App\Controllers;

use App\Models\Usuario_model;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use function App\Helpers\elemento;
use function App\Helpers\subirarchivo;

class Usuario extends ResourceController
{
    use ResponseTrait;

    protected $usuario_model;

    public function __construct()
    {
        helper('utileria'); // Carga del helper
        $this->usuario_model = new Usuario_model();
        $this->format = 'json';
    }

    public function index()
    {
        return $this->failNotFound('Recurso no encontrado');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->usuario_model->buscar($this->request->getGet())
        ];
        return $this->respond($data);
    }

    public function guardar($id = null)
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'POST') {
            $datos = (object) $this->request->getJSON();

            log_message('info','valores de datos guardar usuario'.var_dump((array)$datos));

            if (verPropiedad($datos, 'nombre') && 
                verPropiedad($datos, 'apellido') && 
                verPropiedad($datos, 'usuario') && 
                verPropiedad($datos, 'clave')) {

                $us = new Usuario_model($id);

                if ($us->existe((array)$datos)) {
                    $data['mensaje'] = "Ya existe el usuario que intenta guardar.";
                } else {
                    $datos->clave = md5($datos->clave);

                    if (elemento($_FILES, 'foto') && 
                        elemento($_FILES['foto'], 'tmp_name')) {

                        $foto = subirarchivo([
                            'tmp_name' => $_FILES['foto']['tmp_name'],
                            'type'     => $_FILES['foto']['type'],
                            'name'     => $_FILES['foto']['name'],
                            'carpeta'  => 'perfil'
                        ]);

                        if ($foto) {
                            $datos->foto = $foto->key;
                            $datos->foto_enlace = $foto->link;
                        }
                    }

                    if ($us->guardar($datos)) {
                        $data['exito'] = 1;
                        $texto = empty($id) ? 'creado' : 'actualizado';
                        $data['mensaje'] = "Usuario {$texto} con éxito.";
                        $data['linea'] = $this->usuario_model->buscar(["id" => $us->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $us->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos.";
        }

        return $this->respond($data);
    }

    public function anular_usuario($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $usuario = new Usuario_model($id);

        if ($usuario->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Usuario anulado con éxito.";
        } else {
            $data['mensaje'] = $usuario->getMensaje();
        }

        return $this->respond($data);
    }
}
