<?php

namespace App\Controllers\bodega;

use CodeIgniter\RESTful\ResourceController;
use App\Models\bodega\Tramo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Tramo extends ResourceController
{
    protected $format = 'json';

    protected $tramo_model;

    public function __construct()
    {
        $this->tramo_model = new Tramo_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->tramo_model->_buscar($this->request->getGet())
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
                verPropiedad($datos, "bodega_sector_id")) {

                $tramo = new Tramo_model($id);

                if ($tramo->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                    $data['linea'] = $tramo->_buscar([
                        'id' => $tramo->getPK(),
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $tramo->getMensaje();
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
