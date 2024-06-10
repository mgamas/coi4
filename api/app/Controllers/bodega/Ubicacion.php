<?php

namespace App\Controllers\bodega;

use CodeIgniter\RESTful\ResourceController;
use App\Models\bodega\Ubicacion_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Ubicacion extends ResourceController
{
    protected $format = 'json';

    protected $ubicacion_model;

    public function __construct()
    {
        $this->ubicacion_model = new Ubicacion_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->ubicacion_model->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "codigo") &&
                verPropiedad($datos, "descripcion") &&
                verPropiedad($datos, "bodega_area_id") &&
                verPropiedad($datos, "bodega_sector_id") &&
                verPropiedad($datos, "bodega_tramo_id") &&
                verPropiedad($datos, "rotacion_id")) {

                $ubic = new Ubicacion_model($id);

                if ($ubic->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                    $data['linea'] = $ubic->_buscar([
                        'id' => $ubic->getPK(),
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $ubic->getMensaje();
                }

            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envio de datos";
        }

        return $this->respond($data);
    }
}
