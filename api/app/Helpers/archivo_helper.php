<?php

namespace App\Helpers;

use App\Libraries\Drive;

if (!function_exists('subirArchivo'))
{
	function subirArchivo($datos=[])
	{
		$data = ['exito' => 0];

		if (elemento($datos, 'tmp_name') &&
			elemento($datos, 'type') &&
			elemento($datos, 'name')) {

			$archivo = new Drive();
			if (!isset($datos['carpeta'])) {
				$datos['carpeta'] = 'varios';
			}

			$archivo->set_subcarpeta($datos['carpeta']);

			$fileId = $archivo->subirArchivo([
				'name' => $datos['name'],
				'type' => $datos['type'],
				'tmp_name' => file_get_contents($datos['tmp_name'])
			]);

		    $documento = $archivo->getArchivo($fileId);

		    $data['exito']  = 1;
			$data['key']    = $documento->getId();
			$data['nombre'] = $documento->getName(); 
			$data['tipo'] = $documento->getMimeType(); 
			$data['link']   = "https://drive.google.com/open?id={$documento->id}";
		} else {
			$data['mensaje'] = 'Hacen falta datos obligatorios.';
		}

		return (object) $data;
	}
}

if (!function_exists('get_imagen_drive'))
{
	function get_imagen_drive($key_drive)
	{
		$gd = new Drive();
		$archivo = $gd->descargarArchivo(['fileId' => $key_drive]);

		return (object) [
			'tipo' => $archivo['mimeType'],
			'imagen' => base64_encode($archivo['contents'])
		];
	}
}

/* End of file archivo_helper.php */
/* Location: ./application/helpers/archivo_helper.php */
