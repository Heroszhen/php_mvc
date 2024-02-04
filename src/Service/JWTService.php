<?php

namespace src\Service;

use vendor\JWT\JWT;
use src\Model\User;

class JWTService
{
    public function __construct()
    {}

    public function extractToken(string $authorization):string
    {
        if($authorization === null || $authorization === ""){
            return "";
        }

        $tab = explode(" ", $authorization);

        return $tab[1];
    }

    public function getUserByToken(string $token): ?array
    {
        $jwt = new JWT($_ENV["jwt_key"]);
        $decrypted = $jwt->decryptToken($token);
        if (null === $decrypted) {
            return null;
        }

        $logintime = (new \DateTime($decrypted["date"]))->format("Y-m-d H:i:s");
        $now = (new \DateTime())->format("Y-m-d H:i:s");
        $logintime = strtotime($logintime);
        $now = strtotime($now);
        $days = abs($now - $logintime)/(60 * 60 * 24);
        if ($days >= 1) {
            return null;
        }
        
        $userM = new User();
        $found = $userM->findByEmail($decrypted["email"]);
        if (count($found) > 0) {
            $user = $found[0];
            $user["roles"] = json_decode($user["roles"], true);
            return $user;
        }
        
        return null;
    }
}