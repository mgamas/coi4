<?php

namespace App\Controllers\producto;

use App\Models\producto\Producto_model;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\verPropiedad;
use CodeIgniter\HTTP\Files\UploadedFile;

class Producto extends ResourceController
{
    protected $format = 'json';
    protected $producto_model;

    public function __construct()
    {
        $this->producto_model = new Producto_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->producto_model->buscar($this->request->getGet())
        ];

        return $this->respond($data);
    }

    public function guardar($id = "")
    {
        $data = ["exito" => 0];

        if ($this->request->getMethod() === 'post') {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre") && verPropiedad($datos, "precio")) {

                $producto = $this->producto_model;

                if ($producto->existe($datos)) {
                    $data['mensaje'] = "Ya existe el producto que intenta guardar.";
                } else {

                    $imgFile = $this->request->getFile('imagen');
                    if ($imgFile && $imgFile->isValid() && ! $imgFile->hasMoved()) {
                        $newName = $imgFile->getRandomName();
                        $imgFile->move(WRITEPATH . 'uploads/producto', $newName);

                        $datos->imagen = $newName;
                        $datos->img_enlace = base_url('uploads/producto/' . $newName);
                    }

                    if ($producto->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Registro guardado con éxito." : "Registro actualizado.";
                        $data['linea'] = $producto->buscar(['id' => $producto->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $producto->getMensaje();
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
