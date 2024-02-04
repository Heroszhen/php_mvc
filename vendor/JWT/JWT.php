<?php

namespace vendor\JWT;

class JWT
{
    private $key;
    private $prefix = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.";

    public function __construct(string $key, string $prefix = "")
    {
        $this->key = $key;
        $this->prefix = ($prefix === "") ? $this->prefix : $prefix;
    }

    public function createToken(array $data): string
    {
        $token = $this->encrypt(json_encode($data), $this->key);

        return $this->prefix . $token;
    }

    public function decryptToken(string $token): array
    {
        $tab = explode(".", $token);
        $decrypted = $this->decrypt(end($tab), $this->key);

        return json_decode($decrypted, true);
    }
    
    private function encrypt(string $data, string $key): string
    { 
        $key = md5($key); 
        $x = 0; 
        $len = strlen($data); 
        $l = strlen($key); 
        $char = "";
        $str = "";
        for ($i = 0; $i < $len; $i++){ 
            if ($x == $l){ 
                $x = 0; 
            } 
            $char .= $key[$x]; 
            $x++; 
        } 

        for ($i = 0; $i < $len; $i++){ 
            $str .= chr(ord($data[$i]) + (ord($char[$i])) % 256); 
        } 

        return base64_encode($str); 
    } 


    private function decrypt(string $data, string $key): string
    { 
        $key = md5($key); 
        $x = 0; 
        $data = base64_decode($data); 
        $len = strlen($data); 
        $l = strlen($key); 
        $char = "";
        $str = "";
        for ($i = 0; $i < $len; $i++){ 
            if ($x == $l){ 
                $x = 0; 
            } 
            $char .= substr($key, $x, 1); 
            $x++; 
        } 

        for ($i = 0; $i < $len; $i++){ 
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))){ 
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1))); 
            }else{ 
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1))); 
            } 
        }

        return $str; 
    } 
}