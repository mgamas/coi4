<?php

namespace App\Controllers\bodega;

use CodeIgniter\RESTful\ResourceController;
use App\Models\bodega\Bodega_model;
use App\Models\bodega\Area_model;
use App\Models\bodega\Sector_model;
use App\Models\bodega\Tramo_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Bodega extends ResourceController
{
    protected $format = 'json';

    protected $bodega_model;
    protected $area_model;
    protected $sector_model;
    protected $tramo_model;
    protected $catalogo;

    public function __construct()
    {
        $this->bodega_model = new Bodega_model();
        $this->area_model = new Area_model();
        $this->sector_model = new Sector_model();
        $this->tramo_model = new Tramo_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('Not Found');
    }

    public function get_datos()
    {
        $data = [
            'cat' => [
                'empresas' => $this->catalogo->ver_empresa(),
                'areas'    => $this->area_model->_buscar($this->request->getGet()),
                'sectores' => $this->sector_model->_buscar($this->request->getGet()),
                'tramos'   => $this->tramo_model->_buscar($this->request->getGet()),
                'rotacion' => $this->catalogo->ver_rotacion(),
            ]
        ];

        return $this->respond($data);
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->bodega_model->_buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = json_decode($this->request->getBody());

            if (verPropiedad($datos, "codigo") && verPropiedad($datos, "nombre")) {

                $bodega = new Bodega_model($id);

                if ($bodega->existe($datos)) {
                    $data['mensaje'] = "Ya existe la bodega que intenta guardar.";
                } else {
                    if ($bodega->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";

                        $data['linea'] = $bodega->_buscar([
                            'id'  => $bodega->getPK(),
                            'uno' => true
                        ]);

                    } else {
                        $data['mensaje'] = $bodega->getMensaje();
                    }
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
