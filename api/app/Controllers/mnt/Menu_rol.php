<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Menu_rol_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Menu_rol extends ResourceController
{
    protected $format = 'json';

    protected $menu_rol_model;
    protected $catalogo;

    public function __construct()
    {
        $this->menu_rol_model = new Menu_rol_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

public function buscar()
{
    $data = ['exito' => 0];

    $menu_roles = $this->menu_rol_model->findAll();

    if ($menu_roles) {
        $data['exito'] = 1;
        $data['menu_roles'] = $menu_roles;
    } else {
        $data['mensaje'] = "No se encontraron registros.";
    }

    return $this->respond($data);
}


    public function asignar_menu($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_menu = $this->catalogo->ver_menu_rol([
                'menu_modulo_id' => $datos->menu_modulo_id,
                'rol_id' => $datos->rol_id,
                'activo' => 0,
                'uno' => true
            ]);

            if ($existe_menu) {
                $id = $existe_menu->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'menu_modulo_id') && verPropiedad($datos, 'rol_id')) {
                
                $menu_rol = new Menu_rol_model($id);

                if ($menu_rol->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = "Menu asignado con éxito";
                    $data['reg'] = $this->catalogo->ver_rol_menu([
                        'rol_id' => $datos->rol_id,
                        'menu_modulo_id' => $datos->menu_modulo_id
                    ]);
                } else {
                    $data['mensaje'] = $menu_rol->getMensaje();
                }
            }
        }

        return $this->respond($data);
    }

    public function anular_menu_rol($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $menu_rol = new Menu_rol_model($id);

        if ($menu_rol->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Se ha removido correctamente el menu.";
        } else {
            $data['mensaje'] = $menu_rol->getMensaje();
        }

        return $this->respond($data);
    }
}
