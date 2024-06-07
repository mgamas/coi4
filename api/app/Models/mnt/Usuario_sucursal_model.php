<?php

namespace App\Models\mnt;
use App\Models\General_model;
use function App\Helpers\verConsulta;
use function App\Helpers\elemento;
use CodeIgniter\Model;

class Usuario_sucursal_model extends General_model {

    protected $table = 'usuario_sucursal'; // Asumí que la tabla se llama 'usuario_sucursal'
    protected $primaryKey = 'id';
    protected $allowedFields = ['sucursal_id', 'usuario_id', 'activo','fecha','principal'];

    public $sucursal_id;
    public $usuario_id;
    public $activo = 1;

    public function __construct($id = '')
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function ver_usuario_sucursal($args = [])
    {
        log_message('info', 'ver_usuario_sucursal init');

        if (elemento($args, 'id')) {
            $this->where('id', $args['id']);
        }

        if (elemento($args, 'usuario_id')) {
            $this->where('usuario_id', $args['usuario_id']);
        }

        if (elemento($args, 'sucursal_id')) {
            $this->where('sucursal_id', $args['sucursal_id']);
        }

        if (isset($args['activo'])) {
            $this->where('activo', $args['activo']);
        } else {
            $this->where('activo', 1);
        }

        $query = $this->select('*')
            ->get();

        log_message('info', 'antes de ver consulta ver_usuario_sucursal');

        return verConsulta($query, $args);
    }

}

/* End of file Usuario_sucursal_model.php */
/* Location: ./application/models/Usuario_sucursal_model.php */
