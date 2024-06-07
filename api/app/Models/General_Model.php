<?php
namespace App\Models;
use CodeIgniter\Model;

class General_model extends Model {
    protected $table = "";
    protected $primaryKey = "id";
    protected $pk = null;
    protected $codigo = "";  // Agregar la propiedad codigo
    protected $mensaje = "";
    protected $foreignKey;
    protected $usr = [];

    public function __construct() {
        parent::__construct();
        //$this->table = $this->getTabla();
        log_message('info', 'tabla seteada '. $this->table);
        //$this->usr    = $this->session->userdata('usuario');
        //$session = \Config\Services::session();
        $session = \Config\Services::session();
        $this->usr = $session->get('usuario');
    }

    public function limpiarGeneral() {
        $this->pk = null;
        $this->mensaje = "";
    }

    public function getPK() {
        return $this->pk;
    }

    public function setPK($valor = null) {
        $this->pk = $valor;
        return $this;
    }

    public function setCodigo($valor) {
        $this->codigo = $valor;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje .= $mensaje;
        return $this;
    }

    public function setTabla($nombre) {
        $this->table = $nombre;
        $tmp = explode(".", $nombre);
        $this->primaryKey = count($tmp) > 1 ? $tmp[1] : $tmp[0];
    }

    public function setLlave($nombre) {
        $this->primaryKey = $nombre;
    }

    private function getTabla() {
        return str_replace("_model", "", strtolower(get_class($this)));
    }

    public function setDatos($args = []) {
        foreach ($args as $campo => $valor) {
            if (property_exists($this, $campo)) {
                if (is_object($this->{$campo})) {
                    $this->{$campo}->setPK($valor);
                } else {
                    $this->$campo = $valor;
                }
            }
        }
    }

    public function cargar($valor) {
        $builder = $this->db->table($this->table);
        $tmp = $builder
            ->where($this->primaryKey, $valor)
            ->get()
            ->getRow();

        $var = $this->primaryKey;
        $this->setPK($tmp->$var);

        $this->setDatos($tmp);
    }

    private function getDatos(): object
    {
    $tmp = new \stdClass();

    foreach (get_object_vars($this) as $key => $value) {
        if (property_exists($this, $key)) {
            try {
                $rp = new \ReflectionProperty($this, $key);

                if ($rp->isPublic()) {
                    if (is_object($this->{$key})) {
                        $obj = $this->{$key};
                        $tmp->{$obj->getForanea()} = $obj->getPK();
                    } else {
                        $tmp->{$key} = $value;
                    }
                }
            } catch (\Throwable $th) {
                // Manejo de errores si es necesario
            }
        }
    }

    return $tmp; // Devolver el objeto
    }




    public function guardar($args = [])
    {
    $this->setDatos($args);

    if ($this->_pk === null) {
        if (property_exists($this, 'usuario_id') && empty($this->usuario_id)) {
            $this->usuario_id = $this->usr['id'];
        }

        if ($this->insert($this->getDatos())) {
            $this->cargar($this->insertID());
            return true;
        } else {
            $this->setMensaje("No pude guardar los datos, por favor intente nuevamente.");
        }
    } else {
        $this->where($this->primaryKey, $this->pk)
             ->set($this->getDatos())
             ->update();

        if ($this->db->affectedRows() == 0) {
            $this->setMensaje("Nada que actualizar");
        } else {
            $this->cargar($this->_pk);
            return true;
        }
    }

    return false;
    }


    public function buscar($args = []) {
        $builder = $this->db->table($this->table);
        $inicio = $args["_inicio"] ?? 0;

        if (isset($args["_limite"])) {
            $builder->limit($args["_limite"], $inicio);
            unset($args['_limite']);
        }

        unset($args['_inicio']);

        if (isset($args["descripcion"])) {
            $builder->like('descripcion', $args['descripcion']);
        }

        $bloqueado = [
            '_uno',
            'descripcion',
            '_orden_asc',
            '_orden_desc',
            '_between',
            '_orden_rand'
        ];

        if (count($args) > 0) {
            foreach ($args as $key => $row) {
                if (!in_array($key, $bloqueado)) {
                    $builder->where($key, $row);
                }
            }
        }

        if (isset($args['_between'])) {
            $campo = $args['_between'][0];
            $valor1 = $args['_between'][1];
            $valor2 = $args['_between'][2];

            $builder->where("{$campo} BETWEEN '{$valor1}' AND '{$valor2}'");
        }

        if (isset($args['_orden_rand'])) {
            $builder->orderBy('rand()');
        }

        if (isset($args['_orden_asc'])) {
            $builder->orderBy($args['_orden_asc'], 'asc');
        }

        if (isset($args['_orden_desc'])) {
            $builder->orderBy($args['_orden_desc'], 'desc');
        }

        $tmp = $builder->get();

        if (isset($args['_uno'])) {
            return $tmp->getRow();
        }

        return $tmp->getResult();
    }
}
?>
