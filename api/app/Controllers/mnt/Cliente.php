<?php

namespace App\Controllers\mnt;

use CodeIgniter\RESTful\ResourceController;
use App\Models\mnt\Cliente_model;
use App\Models\catalogo_model;
use function App\Helpers\verPropiedad;
use function App\Helpers\Hoy;
use function App\Helpers\elemento;

class Cliente extends ResourceController
{
    protected $format = 'json';

    protected $cliente_model;
    protected $catalogo;

    public function __construct()
    {
        $this->cliente_model = new Cliente_model();
        $this->catalogo = new catalogo_model();
    }

    public function index()
    {
        return $this->failNotFound('No se encontró la ruta solicitada.');
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->cliente_model->buscar($this->request->getGet())
        ];
    
        return $this->respond($data);
    }


    //public function buscar()
    //{
      //  $data = [
        //    'lista' => $this->cliente_model->buscar($this->request->getGet())
        //];

        //return $this->respond($data);
    //}

    public function guardar($id = '')
    {
        $data = ["exito" => 0];
        
        if ($this->request->getMethod() === "post") {
            $datos = (object) $this->request->getPost();

            if (verPropiedad($datos, "nombre_comercial") && 
                verPropiedad($datos, "cliente_tipo_id")) {

                $cliente = new Cliente_model($id);

                if ($cliente->existe($datos)) {
                    $data['mensaje'] = "Los datos ya se encuentran almacenados.";
                } else {
                    if ($cliente->guardar($datos)) {
                        $data['exito'] = 1;
                        $data['mensaje'] = empty($id) ? "Cliente guardado con éxito." : "Cliente actualizado con éxito.";
                        $data['linea'] = $cliente->buscar(['id' => $cliente->getPK(), 'uno' => true]);
                    } else {
                        $data['mensaje'] = $cliente->getMensaje();
                    }
                }
            } else {
                $data['mensaje'] = "Complete todos los campos marcados con *.";
            }
        } else {
            $data['mensaje'] = "Error en el envío de datos.";
        }

        return $this->respond($data);
    }

    public function anular_cliente($id)
    {
        $data = ['exito' => 0];
        $datos = ['activo' => 0];

        $cliente = new Cliente_model($id);

        if ($cliente->guardar($datos)) {
            $data['exito'] = 1;
            $data['mensaje'] = "Cliente anulado con éxito.";
        } else {
            $data['mensaje'] = $cliente->getMensaje();
        }

        return $this->respond($data);
    }
}
