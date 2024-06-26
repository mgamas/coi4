<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use function App\Helpers\elemento;
use CodeIgniter\API\ResponseTrait;

class Catalogo extends ResourceController
{
    use ResponseTrait;

    protected $catalogoModel;

    public function __construct()
    {
        // Cargar el modelo
        $this->catalogoModel = new \App\Models\Catalogo_Model();
    }

    public function index()
    {
        return $this->response->setStatusCode(404);
    }

    public function ver_lista()
    {
        $lista = [];
        $args = [];
        log_message("info","ver_lista en catalogo controller init");
        if ($this->request->getGet('args')) {
            $args = json_decode(json_encode($this->request->getGet('args')), true);
        }
        
        foreach ($this->request->getGet('lista') as $key => $value) {
            $tmp = "ver_{$value}";
            $ar = elemento($args, $value, []);

            if (method_exists($this->catalogoModel, $tmp)) {
                //log_message('info','ver args catalogo before call '.$ar );
               // log_message('info','ver lista catalogo before call '.$tmp);
               if (is_string($ar)) {
                $ar = json_decode($ar, true);
            }
                $lista[$value] = $this->catalogoModel->$tmp($ar);
            } else {
                $lista[$value] = "Método {$tmp} no encontrado en CatalogoModel";
            }
        }

        return $this->respond([
            'exito' => true,
            'lista' => $lista
        ]);
    }
}
