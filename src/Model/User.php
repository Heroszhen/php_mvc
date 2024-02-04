<?php

namespace src\Model;

use Config\AbstractModel;

class User extends AbstractModel
{
    public function getFields(): array
    {
        return [
            'name' => '',
            'age' => null
        ];
    }

    // public function findByEmail(string $email): array
    // {
    //     $req = "select * from user where email = :email";
    //     $result = $this->execRequete($req, [":email" => $email]);
        
    //     return $result->fetchAll();
    // }

    // public function adjustUser(array $user):array 
    // {
    //     unset($user["password"]);
    //     $user["roles"] = json_decode($user["roles"], true);

    //     return $user;
    // }
}
