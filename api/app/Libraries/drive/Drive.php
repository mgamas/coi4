<?php

namespace App\Libraries;

use Google\Client;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;
use Google\Service\Drive\Permission as Google_Service_Drive_Permission;


class Drive
{
    public $servicio;
    protected $carpeta = '1XDvFr87YkK91tOic--135tTqz9lerSRA';
    protected $subcarpeta = 'otros';

    public function __construct()
    {
        $this->servicio = new Google_Service_Drive($this->getCliente());
    }

    private function getCliente()
    {
        $client = new Client();
        $client->setApplicationName('Favi');
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setAuthConfig(APPPATH . 'Libraries/drive/favi_drive.json');
        $client->setAccessType('online');

        return $client;
    }

    public function setSubcarpeta($nombre)
    {
        $this->subcarpeta = $nombre;
    }

    public function getArchivo($id, $args = [])
    {
        return $this->servicio->files->get($id, $args);
    }

    public function mostrarArchivo($id)
    {
        return $this->servicio->files->get($id, ['action' => 'open']);
    }

    
    public function setPermiso($args = [])
    {
        $this->servicio->getClient()->setUseBatch(true);

        try {
            $batch = $this->servicio->createBatch();

            $userPermission = new Google_Service_Drive_Permission([
                'type' => $args['type'],
                'role' => $args['role']
            ]);

            $request = $this->servicio->permissions->create(
                $args['fileId'],
                $userPermission,
                ['fields' => 'id']
            );

            $batch->add($request, 'anyone');
            $batch->execute();
        } finally {
            $this->servicio->getClient()->setUseBatch(false);
        }
    }

    public function subirArchivo($args = [])
    {
        $file = new Google_Service_Drive_DriveFile([
            'name' => $args['name'],
            'parents' => [$this->getCarpeta($this->subcarpeta)]
        ]);

        $tmp = $this->servicio->files->create($file, [
            'data' => file_get_contents($args['tmp_name']),
            'mimeType' => $args['type'],
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        $this->setPermiso([
            'fileId' => $tmp->id,
            'type' => 'anyone',
            'role' => 'commenter'
        ]);

        return $tmp->id;
    }

    public function setCarpeta($nombre)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $nombre,
            'parents' => [$this->carpeta],
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        $file = $this->servicio->files->create($fileMetadata, ['fields' => 'id']);

        return $file->id;
    }

    public function getCarpeta($carpeta)
    {
        $pageToken = null;

        do {
            $response = $this->servicio->files->listFiles([
                'q' => "name='{$carpeta}'",
                'spaces' => 'drive',
                'pageToken' => $pageToken,
                'fields' => 'nextPageToken, files(id, name)',
            ]);

            foreach ($response->files as $file) {
                if ($file->name == $carpeta) {
                    return $file->id;
                }
            }

            $pageToken = $response->pageToken;
        } while ($pageToken != null);

        return $this->setCarpeta($carpeta);
    }

    public function descargarArchivo($args = [])
    {
        $response = $this->getArchivo($args['fileId'], ['alt' => 'media']);
        $archivo = $this->getArchivo($args['fileId']);

        return [
            'contents' => $response->getBody()->getContents(),
            'mimeType' => $archivo->mimeType,
            'name' => $archivo->name
        ];
    }
}

/* End of file Drive.php */
/* Location: ./app/Libraries/Drive.php */
