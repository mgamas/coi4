<?php

namespace App\Controllers\bodega;

use CodeIgniter\RESTful\ResourceController;
use App\Models\bodega\Sector_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Sector extends ResourceController
{
    protected $format = 'json';

    protected $sector_model;

    public function __construct()
    {
        $this->sector_model = new Sector_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->sector_model->_buscar($this->request->getGet())
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
                verPropiedad($datos, "bodega_area_id")) {

                $sector = new Sector_model($id);

                if ($sector->guardar($datos)) {
                    $data['exito'] = 1;
                    $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                    $data['linea'] = $sector->_buscar([
                        'id' => $sector->getPK(),
                        'uno' => true
                    ]);

                } else {
                    $data['mensaje'] = $sector->getMensaje();
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
