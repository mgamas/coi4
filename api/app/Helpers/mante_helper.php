<?php

namespace App\Helpers;

if (!function_exists('dato_requerido')) {
    function dato_requerido($datos = [], $tipo = 0)
    {
        switch ($tipo) {
            case 1:
                $obligatorios = [
                    'nombre' => 'Nombre proveedor'
                ];
                break;
            case 2:
                $obligatorios = [
                    'nombre' => "Nombre sucursal",
                    'direccion' => "Dirección sucursal",
                    'empresa_id' => "Empresa"
                ];
                break;
            default:
                return false;
        }

        return validar_requerido($datos, $obligatorios);
    }
}

if (!function_exists('validar_requerido')) {
    function validar_requerido($datos = [], $obligatorios = [])
    {
        $mensaje = '';
        if ($datos && $obligatorios) {
            foreach ($obligatorios as $key => $value) {
                //if (!verPropiedad($datos, $key)) { its the original insctruction
                if (!array_key_exists($key, $datos)) {
                    $mensaje .= "<br>{$value}\n";
                }
            }
        }
        return $mensaje;
    }
}

?>
