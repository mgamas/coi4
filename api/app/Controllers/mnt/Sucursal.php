<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Sucursal_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Sucursal extends ResourceController
{
    protected $format = 'json';

    protected $sucursal_model;
    protected $catalogo;

    public function __construct()
    {
        $this->sucursal_model = new Sucursal_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->sucursal_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ['exito' => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = $this->request->getJSON();

            if (verPropiedad($datos, 'nombre') && verPropiedad($datos, 'empresa_id')) {
                $sucursal = new Sucursal_model($id);

                if ($sucursal->existe_sucursal(['nombre' => $datos->nombre, 'empresa_id' => $datos->empresa_id])) {
                    $data['mensaje'] = "La sucursal ya está registrada.";
                } else {
                    if ($sucursal->guardar($datos)) {
                        $data['exito'] = 1;
                        $termino = empty($id) ? 'guardada' : 'actualizada';
                        $data['mensaje'] = "Sucursal {$termino} con éxito";
                        $data['linea'] = $sucursal->buscar(['id' => $sucursal->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $sucursal->getMensaje();
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
