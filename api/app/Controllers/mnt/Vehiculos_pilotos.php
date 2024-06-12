<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Helpers\verPropiedad;
use App\Helpers\Hoy;
use App\Helpers\elemento;
use App\Models\mnt\Vehiculos_Pilotos_model;
use App\Models\Catalogo_model;

class Vehiculos_pilotos extends ResourceController
{
    protected $format = 'json';
    protected $vehiculos_pilotos_model;
    protected $catalogo;

    public function __construct()
    {
        $this->vehiculos_pilotos_model = new Vehiculos_Pilotos_model();
        $this->catalogo = new Catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = ['exito' => 0];
    
        $vehiculos_pilotos = $this->vehiculos_pilotos_model->findAll();
    
        if ($vehiculos_pilotos) {
            $data['exito'] = 1;
            $data['vehiculos_pilotos'] = $vehiculos_pilotos;
        } else {
            $data['mensaje'] = "No se encontraron registros.";
        }
    
        return $this->respond($data);
    }


    public function asignar_Vehiculos_Pilotos($id = null)
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = json_decode($this->request->getBody());

            $existe_vehiculo = $this->catalogo->ver_vehiculos_pilotos([
                'vehiculos_id' => $datos->vehiculos_id,
                'pilotos_id' => $datos->pilotos_id,
                'activo' => 0,
                'uno' => true
            ]);

            if ($existe_vehiculo) {
                $id = $existe_vehiculo->id;
                $datos->activo = 1;
            }

            if (verPropiedad($datos, 'vehiculos_id') && verPropiedad($datos, 'pilotos_id')) {
                $clsucursal = new Vehiculos_Pilotos_model($id);

                if ($clsucursal->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                    $data['reg'] = $this->catalogo->ver_vehiculos_pilotos([
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

    public function anular_vehiculos_pilotos($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $sucursal = new Vehiculos_Pilotos_model($id);

        if ($sucursal->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Registro guardado con éxito.";
        } else {
            $data['mensaje'] = $sucursal->getMensaje();
        }

        return $this->respond($data);
    }
}
