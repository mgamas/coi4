<?php

namespace App\Controllers;
use App\Models\mnt\Sucursal_model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\RESTful\ResourceController;
use App\Models\usuario_model;
use App\Models\mnt\Empresa_model;
use App\Models\mnt\Usuario_sucursal_model;
use App\Models;
use function App\Helpers\var_session;
use App\Libraries\Token;

class Sesion extends ResourceController
{
    protected $usuario_model;
    protected $empresa_model;
    protected $sucursal_model;
    protected $usuario_sucursal_model;
    protected $token;

    public function __construct()
    {
        helper(['array', 'log']);
        $this->usuario_model = new usuario_model();
        $this->empresa_model = new Empresa_model();
        $this->sucursal_model = new Sucursal_model();
        $this->usuario_sucursal_model = new Usuario_sucursal_model();
        $this->token = new Token();
        //$this->response->setHeader('Content-Type', 'application/json');
    }
 
    public function index()
    {
        //return $this->response->setStatusCode(405);
        //log_message('info', 'Encabezados usuario y clave encontrados');
        //echo ENVIRONMENT;
        //return "HOla mundo";
       //echo "hola mundo";
       
       $db = \Config\Database::connect();

       try {
           if ($db->connect()) {
               echo "Conexión exitosa a la base de datos.";
           }
       } catch (DatabaseException $e) {
           echo "Error al conectar a la base de datos: " . $e->getMessage();
       }
    }

    public function login()
    {
        $data = ['exito' => 0];
    
        try {
            log_message('info', 'Método login llamado '.$this->request->getMethod());
    
            if ($this->request->getMethod() === 'POST') {
                log_message('info', 'Método de solicitud POST confirmado');
    
                $headers = array_change_key_case($this->request->getHeaders());
                $headers = array_map(function($header) {
                    return is_array($header) ? implode(', ', $header) : $header;
                }, $headers);
    
                log_message('info', 'Encabezados de solicitud: ' . json_encode($headers));
    
                if (isset($headers['usuario']) && isset($headers['clave'])) {
                    log_message('info', 'Encabezados usuario y clave encontrados');
    
                    if ($this->usuario_model->login(['usuario' => $headers['usuario'], 'clave' => $headers['clave']])) {
                        log_message('info', 'Autenticación de usuario exitosa');
                        
                        $usuario_id = $this->usuario_model->getPK();
                        log_message('info', 'usuario_id_registrado '. $usuario_id);
                        $uSucursal = $this->usuario_sucursal_model->ver_usuario_sucursal(['usuario_id' => $usuario_id, 'uno' => true]);
    
                        if (is_object($uSucursal) || is_array($uSucursal)) {
                            log_message('info', 'Sucursal de usuario encontrada');
    
                            $sucursal = new Sucursal_model($uSucursal->sucursal_id);
                            $empresa_id = $sucursal->empresa_id;
                            $empresa = new Empresa_model($empresa_id);
    
                            $usuario = $this->usuario_model;
                            $usuario->empresa_id = $empresa->getPK();
                            $usuario->empresa = $empresa->nombre;
                            $usuario->sucursal_id = $uSucursal->sucursal_id;
                            $usuario->sucursal = $sucursal->nombre;
                            log_message('info', 'usuario listo para sesion');
                            $usuario_session = var_session($usuario);
                            log_message('info', 'usuario listo para JWT');
                            $JWT = new Token();
                            $data['token'] = $JWT->set_token($usuario_session);
                            log_message('info', 'JWT creado'. $data['token']);

                            $isusuarioarray = is_array(["usuario" => $usuario_session]);
                            log_message('info', 'isusuarioarray '. $isusuarioarray);

                            //$session = session();
                            log_message('info', 'antes de  Set session');
                            session()->set(["usuario" => $usuario_session]);

                            log_message('info', 'session Set');
                            $data["usuario"] = $usuario_session;
                            $data["mensaje"] = "Bienvenido {$usuario->nombre} a Favi.";
                            $data["exito"] = 1;
                        } else {
                            $data['mensaje'] = 'El usuario no está asignado a ninguna sucursal';
                        }
                    } else {
                        $data["mensaje"] = "Usuario o clave incorrecta, intente de nuevo.";
                    }
                } else {
                    $data["mensaje"] = "Ingrese las credenciales.";
                }
            } else {
                $data['mensaje'] = 'Método de envío incorrecto';
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en el método login: ' . $e->getMessage());
            $data['mensaje'] = $e->getMessage();
        }
    
        return $this->response->setJSON($data);
    }
    
        public function logout()
        {
            $data = ['exito' => 0];
    
            try {
                session()->destroy();
                $data['exito'] = 1;
                $data['mensaje'] = "Sesión finalizada.";
            } catch (\Exception $e) {
                log_message('error', 'Error en el método logout: ' . $e->getMessage());
                $data['mensaje'] = $e->getMessage();
            }
    
            return $this->response->setJSON($data);
        }
    
        public function validar_token()
        {
            $data = ['valido' => 0];
    
            try {
                $datos = $this->request->getJSON();
                $JWT = new Token();
    
                if (is_null($datos->token)) {
                    $data['mensaje'] = 'Tiempo agotado de sesion.';
                } else {
                    if ($JWT->token_valido($datos->token)) {
                        $data['valido'] = 1;
                        $data['mensaje'] = "Token válido";
                    } else {
                        return $this->response->setStatusCode(401)->setJSON(['mensaje' => 'Acceso denegado.']);
                    }
                }
            } catch (\Exception $e) {
                log_message('error', 'Error en el método validar_token: ' . $e->getMessage());
                $data['mensaje'] = $e->getMessage();
            }
    
            return $this->response->setJSON($data);
        }

        public function options()
    {
        $response = service('response');
        $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8081'); // Especifica el origen correcto
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, clave, usuario, X-Requested-With, x-xsrf-token');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    }
}
