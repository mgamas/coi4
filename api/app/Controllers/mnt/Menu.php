<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Menu_model;
use App\Models\mnt\Menu_modulo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Menu extends ResourceController
{
    protected $format = 'json';

    protected $menu_model;
    protected $menu_modulo_model;

    public function __construct($id = '')
    {
        $this->menu_model = new Menu_model();
        $this->menu_modulo_model = new Menu_modulo_model();
       
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->menu_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function get_modulos()
    {
        $user = session()->get('usuario');
        log_message('info', 'Usuario: '.json_encode($user));
        $modulos = $this->menu_model->buscar(['rol_id' => $user['id']]);

        if ($modulos) {
            foreach ($modulos as $row) {
                $datos = $this->menu_modulo_model->buscar([
                    'modulo' => $row->id,
                    'rol_id' => $user['id']
                ]);

                $row->opciones = $datos ? $datos : false;
            }
        }

        return $this->respond(['lista' => $modulos ? $modulos : []]);
    }

    public function get_opciones()
    {
        $opciones = $this->menu_modulo_model->buscar($this->request->getGet());

        return $this->respond(['lista' => $opciones ? $opciones : []]);
    }

    public function anular_modulo($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $menu = new Menu_model($id);

        if ($menu->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Módulo anulado con éxito.";
        } else {
            $data['mensaje'] = $menu->getMensaje();
        }

        return $this->respond($data);
    }

    public function anular_opcion($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $menu = new Menu_modulo_model($id);

        if ($menu->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Opción anulada con éxito.";
        } else {
            $data['mensaje'] = $menu->getMensaje();
        }

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'nombre') && 
                verPropiedad($datos, 'url') && 
                verPropiedad($datos, 'icono')) {

                $menu = new Menu_model($id);
                
                if ($menu->guardar($datos)) {
                    $data['exito'] = 1;
                    $termino = empty($id) ? 'guardado' : 'actualizado';
                    $data['mensaje'] = "Módulo {$termino} con éxito";
                    $data['linea'] = $menu->_buscar(['id' => $menu->getPK(), 'uno' => true]);
                } else {
                    $data['mensaje'] = $menu->getMensaje();
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Método de envío incorrecto";
        }

        return $this->respond($data);
    }

    public function guardar_opcion($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'nombre') && 
                verPropiedad($datos, 'url') && 
                verPropiedad($datos, 'icono')) {

                $mm = new Menu_modulo_model($id);
                
                if ($mm->guardar($datos)) {
                    $data['exito'] = 1;
                    $termino = empty($id) ? 'guardada' : 'actualizada';
                    $data['mensaje'] = "Opción {$termino} con éxito";
                    $data['linea'] = $mm->_buscar(['id' => $mm->getPK(), 'uno' => true]);
                } else {
                    $data['mensaje'] = $mm->getMensaje();
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Método de envío incorrecto";
        }

        return $this->respond($data);
    }
    public function options()
    {
        $response = service('response');
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', '*');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}
