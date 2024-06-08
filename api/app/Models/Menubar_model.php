<?php 

namespace App\Models;

use CodeIgniter\Model;
use function App\Helpers\elemento;

class Menubar_model extends General_model {

    protected $table = 'menu_modulo';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nombre', 'icono', 'url', 'activo', 'modulo_id'
    ];

    public function buscar($args = [])
    {
        $menuItems = [];

        if (isset($args['usuario_id'])) {
            $this->where('ru.usuario_id', $args['usuario_id']);
        }

        $tmp = $this->db->table('menu_modulo m')
            ->select('m.*')
            ->join('menu_rol mr', 'mr.menu_modulo_id = m.id', 'inner')
            ->join('rol r', 'r.id = mr.rol_id', 'inner')
            ->join('rol_usuario ru', 'ru.rol_id = r.id', 'inner')
            ->where('m.activo', 1)
            ->where('mr.activo', 1)
            ->where('ru.usuario_id', $args['usuario_id'] ?? 1)
            ->get();

        $result = $tmp->getResult();

        foreach ($result as $fila) {
            $items = [
                "id" => $fila->id,
                "url" => $fila->url,
                "icon" => !empty($fila->icono) ? $fila->icono : 'fa fa-home',
                "text" => $fila->nombre,
               // "level" => $fila->nivel,
               // "father" => $fila->padre
            ];

            array_push($menuItems, $items);
        }

        return json_encode($menuItems);
    }
}

/* End of file Menubar_model.php */
/* Location: ./app/Models/Menubar_model.php */
