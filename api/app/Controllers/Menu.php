<?php

namespace App\Controllers;

use App\Models\mnt\Menu_model;
use CodeIgniter\RESTful\ResourceController;

class Menu extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new Menu_model();
    }

    public function index()
    {
        return $this->failNotFound('Resource not found');
    }

    public function buscar()
    {
        return $this->respond([
            'lista' => $this->model->buscar()
        ]);
    }
}

/* End of file Menu.php */
/* Location: ./app/Controllers/Menu.php */
