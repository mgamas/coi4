<?php

namespace Config;
use CodeIgniter\Session\Handlers\FileHandler;
use CodeIgniter\Config\BaseService;
use CodeIgniter\Session\Session;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Session as SessionConfig;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

     
        /*public static function session(APP $config = null,  $getShared = false)
    {
         log_message('info', 'init load sesion');
        if ($getShared) {
            return static::getSharedInstance('session', $config);
        }
        log_message('info', 'after if load sesion');
       
        $config = $config ?? config(App::class);
        
        $sessionConfig = config(SessionConfig::class);
        log_message('debug', 'Session config: ' . print_r($sessionConfig, true));
        
        $request = static::request();
        
        $ipAddress = $request->getIPAddress();
      
        
        log_message('debug', 'IP Address: ' . $ipAddress);
         
        $handler = new FileHandler($sessionConfig, $ipAddress);

        return new Session($handler, $sessionConfig); 
    }*/
}
