<?php
namespace Config\Database;

use PDO;

class ConnectMysql
{
    private static $pdo = null;

    private function __construct()
    {}

    public static function getPDO()
    {
        if (self::$pdo === null) {
            $config = include dirname(__DIR__,2).'/Config/Config.php';
            $pdo = new PDO(
                'mysql:host='.$config["host"].';dbname='.$config["dbname"],
                $config["username"],
                $config["password"],
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                )
            );
        }

        return $pdo;
    }
}
 