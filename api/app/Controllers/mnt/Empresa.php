<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Empresa_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Empresa extends ResourceController
{
    protected $format = 'json';

    protected $empresa_model;
    protected $catalogo;

    public function __construct()
    {
        $this->empresa_model = new Empresa_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->empresa_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = '')
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre") && verPropiedad($datos, "razon_social")
                && verPropiedad($datos, "representante") && verPropiedad($datos, "nit")) {

                $empresa = new Empresa_model($id);

                if ($empresa->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {

                    if (elemento($_FILES, 'imagen') && 
                        elemento($_FILES['imagen'], 'tmp_name')) {
                    
                        $imagen = $this->subirArchivo([
                            'tmp_name' => $_FILES['imagen']['tmp_name'],
                            'type'     => $_FILES['imagen']['type'],
                            'name'     => $_FILES['imagen']['name'],
                            'carpeta'  => 'empresa'
                        ]);

                        if ($imagen) {
                            $datos->logo = $imagen->key;
                            $datos->logo_enlace = $imagen->link;
                        } 
                    }

                    if ($empresa->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $empresa->buscar(['id' => $empresa->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $empresa->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos";
        }

        return $this->respond($data);
    }

    private function subirArchivo($params)
    {
        // Lógica para subir archivo
    }
}
