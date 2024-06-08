<?php

namespace App\Controllers;

use App\Models\Menubar_model;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

class Menubar extends ResourceController
{
    use ResponseTrait;

    protected $menubar_model;

    public function __construct()
    {
        $this->menubar_model = new Menubar_model();
    }

    public function index()
    {
        return $this->failNotFound();
    }

    public function buscar()
    {
        $data = [
            'lista' => $this->menubar_model->buscar()
        ];

        return $this->respond($data);
    }
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
