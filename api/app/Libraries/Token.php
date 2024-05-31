<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Token
{
    private $secret_key = 'favi';
    private $encrypt = 'HS256';

    public function setToken($data = [])
    {
        $config = [
            'iat'  => time(),
            'exp'  => time() + 7200,
            'data' => $data
        ];

        return JWT::encode($config, $this->secret_key, $this->encrypt);
    }

    public function isValidToken($token)
    {
        if (is_string($token) && !empty($token)) {
            try {
                $decoded = JWT::decode($token, new Key($this->secret_key, $this->encrypt));
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }   
    
    public function getDataFromToken($token)
    {
        $tmp = JWT::decode($token, new Key($this->secret_key, $this->encrypt));
        return $tmp->data;
    }
}
