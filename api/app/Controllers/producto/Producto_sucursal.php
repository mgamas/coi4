<?php

namespace App\Controllers\producto;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\producto\Producto_sucursal_model;

class Producto_sucursal extends ResourceController
{
    use ResponseTrait;

    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new Producto_sucursal_model();
    }

    public function buscar($id = null)
    {
        if ($id === null) {
            $data = $this->model->findAll();
        } else {
            $data = $this->model->find($id);
        }

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }



    public function create()
    {
        $data = $this->request->getJSON();
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Producto_sucursal created successfully'
            ]
        ];

        return $this->respondCreated($data, 'Producto_sucursal created successfully');
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Producto_sucursal updated successfully'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Producto_sucursal deleted successfully'
            ]
        ];

        return $this->respondDeleted($response);
    }
}
