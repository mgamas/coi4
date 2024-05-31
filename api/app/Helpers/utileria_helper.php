<?php 

namespace App\Helpers;

use App\Libraries\Drive;

use Config\Services;

if (!function_exists('elemento'))
{
	function elemento($dato, $indice, $valor=false) 
	{	
		if (array_key_exists($indice, $dato) && 
			!empty($dato[$indice])) {
			
			return $dato[$indice];
		}

		return $valor;
	}
}

if (!function_exists('verPropiedad'))
{
	function verPropiedad($dato, $indice, $valor=false) 
	{
		if (property_exists($dato, $indice) && 
			!empty($dato->$indice)) {
			
			return $dato->$indice;
		}

		return $valor;
	}
}

if (!function_exists('verConsulta'))
{
	function verConsulta($datos, $args)
	{
		if ($datos->num_rows() > 0) {
			if (isset($args['uno'])) {
				return $datos->row();
			} else {
				return $datos->result();
			}
		}

		return [];
	}
}

if (!function_exists('var_session'))
{
	function var_session($data=[])
	{
		// Convert array to object
        $data = (object) $data;
		$nombre   = explode(" ", $data->nombre);
		$apellido = explode(" ", $data->apellido);

		$sesion = [
			"id"          => $data->id,
			//Nombre y apellido cambiados de 
			//"nombre"      => $nombre[0],
			//"apellido"    => $apellido[0],
			"nombre"      => $nombre,
			"apellido"    => $apellido,
			"usuario"     => $data->usuario,
			"sucursal_id" => $data->sucursal_id,
			"sucursal"    => $data->sucursal,
			"empresa_id"  => $data->empresa_id,
			"empresa"     => $data->empresa
		];


		return $sesion;
	}
}

if (!function_exists('outputJson')) {
	function outputJson ($data=[])
	{
		header('Content-type: application/json');
	    echo json_encode($data);	
	}
}

if (!function_exists('generarCodigo')) {
	function generarCodigo($longitud=10) 
	{
		$cadena ='23456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$cadenaAncho = strlen($cadena);

		$codigo = '';
		for ($i=0; $i < $longitud ; $i++) { 
			$codigo .= $cadena[rand(0, $cadenaAncho - 1)];
		}
		return $codigo;

	}
}

if (!function_exists('get_tiempo_token')) {
	function get_tiempo_token()
	{
		return time()+7200;
	}
}

if (!function_exists('getRealIP')) {
	function getRealIP() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        return $_SERVER['HTTP_CLIENT_IP'];
	       
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	   
	    return $_SERVER['REMOTE_ADDR'];
	}
}

if (!function_exists('eliminaAcento'))
{
	function eliminarAcento($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array (
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
    }
}


if (!function_exists('script_tag')) {
    function script_tag($src, $print=false)
    {
        if ($print) {
            $link = "<script type='text/javascript'>\n" . file_get_contents(base_url($src)) . "\n</script>\n";
        } else {
            $link = '<script type="text/javascript" ';
            if (preg_match('#^([a-z]+:)?//#i', $src)) {
                $link .= 'src="'.$src.'" ';
            } else {
                $link .= 'src="'.base_url($src).'" ';
            }
            $link .= "></script>\n";
        }
        return $link;
    }
}


if (!function_exists('censurar_mail')) {
	function censurar_mail($mail='')
	{
		if ($mail) {
		    $em   = explode("@",$mail);
		    $name = implode('@', array_slice($em, 0, count($em)-1));
		    $len  = floor(strlen($name)/2);

		    return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
		}

		return false;
	}
}

if (!function_exists('sumar_tiempo')) {
	function sumar_tiempo($tiempo) {		
		$ahora = date('Y-m-d H:i:s');
		$tiempo = explode(':',  $tiempo);
		$nuevaFecha = strtotime("+"."{$tiempo[0]}"."hour"."{$tiempo[1]}"."minute" ,strtotime ($ahora)); 

		return date('Y-m-d H:i:s', $nuevaFecha);
	}
}

if (!function_exists('array_field')) {
	function array_field($data, $field)
	{
		$values = [];

		if ($data) {
			foreach ($data as $row) {
				$values[] = $row->$field;
			}
		}

		return $values;
	}
}

if (!function_exists('verLetra')) {
	function verLetra($num) {

		$numero = $num % 26;
		$letra  = chr(65 + $numero);
		$num2   = intval($num / 26);

	    if ($num2 > 0) {
	        return verLetra($num2 - 1) . $letra;
	    } else {
	        return $letra;
	    }
	}
}

if (!function_exists('Hoy')) {
	function Hoy($hora = false)
	{
		if ($hora === true) {
			return date('Y-m-d H:i:s');
		}

		return date('Y-m-d');
	}
}

?>