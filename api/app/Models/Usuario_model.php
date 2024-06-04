<?php namespace App\Models;
use function App\Helpers\verConsulta;
use CodeIgniter\Model;

class Usuario_model extends General_model {

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nombre', 'apellido', 'usuario', 'clave', 'telefono', 'correo',
        'foto', 'foto_enlace', 'vence_clave', 'fecha_clave_vence',
        'fecha_anulado', 'activo'
    ];

    public $nombre;
    public $apellido;
    public $usuario;
    public $clave;
    public $telefono = null;
    public $correo = null;
    public $foto = null;
    public $foto_enlace = null;
    public $vence_clave = null;
    public $fecha_clave_vence = null;
    public $fecha_anulado = null;
    public $activo = 1;

    public function __construct($id = null)
    {
        parent::__construct();
        if (!empty($id)) {
            $this->cargar($id);
        }
    }

    public function login($args = [])
    {
        $clave = $args['clave'];

        $tmp = $this->where('usuario', $args['usuario'])
                    ->where('clave', md5($clave))
                    ->where('activo', 1)
                    ->first();

        if ($tmp) {
            $this->cargar($tmp['id']);
            return true;
        }

        return false;
    }

    public function buscar($args = [])
    {
        if (isset($args['id'])) {
            $this->where('id', $args['id']);
        }

        $tmp = $this->select('a.*')
                    // ->join('rol_usuario b', 'b.usuario_id = a.id', 'left')
                    // ->join('rol c', 'c.id = b.rol_id', 'left')
                    // ->join('usuario_sucursal d', 'd.usuario_id = a.id', 'left')
                    // ->join('sucursal e', 'e.id = d.sucursal_id', 'left')
                    // ->where('b.activo', 1)
                    ->where('a.activo', 1)
                    ->findAll();

        return verConsulta($tmp, $args);
    }

    public function existe($args = [])
    {
        if ($this->primaryKey) {
            $this->where('id !=', $this->primaryKey);
        }

        $tmp = $this->where('usuario', $args['usuario'])
                    ->findAll();

        return count($tmp) > 0;
    }
}
