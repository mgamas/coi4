<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Empleado_sucursal_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Empleado_sucursal extends ResourceController
{
    protected $format = 'json';

    protected $empleado_sucursal_model;
    protected $catalogo;

    public function __construct()
    {
        $this->empleado_sucursal_model = new Empleado_sucursal_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

public function buscar()
{
    $data = ['exito' => 0];

    $empleados_sucursales = $this->empleado_sucursal_model->findAll();

    if ($empleados_sucursales) {
        $data['exito'] = 1;
        $data['mensaje'] = "Registros encontrados.";
        $data['registros'] = $empleados_sucursales;
    } else {
        $data['mensaje'] = "No se encontraron registros.";
    }

    return $this->respond($data);
}



    public function asignar_empleado_sucursal($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();
            
            $existe_sucursal = $this->catalogo->ver_empleado_sucursal([
                'empleado_id' => $datos->empleado_id, 
                'sucursal_id' => $datos->sucursal_id, 
                'activo' => 0, 
                'uno' => true
            ]);
            
            if ($existe_sucursal) {
                $id = $existe_sucursal->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'empleado_id') && 
                verPropiedad($datos, 'sucursal_id')) {
                
                $clsucursal = new Empleado_sucursal_model($id);

                if ($clsucursal->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                    $data['reg'] = $this->catalogo->ver_empleado_sucursal([
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

    public function anular_empleado_sucursal($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $sucursal = new Empleado_sucursal_model($id);

        if ($sucursal->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                
        } else {
            $data['mensaje'] = $sucursal->getMensaje();
        }

        return $this->respond($data);
    }
}
