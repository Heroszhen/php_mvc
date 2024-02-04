<?php
namespace Config;

use Config\Router;
use Config\Database\ConnectMysql;

class Kernel
{
    public function run()
    {
        $this->setEnv();

        $router = new Router();
        $router->setRoutes();
        $router->getRouter();
    }

    public function getPDO()
    {
        return ConnectMysql::getPDO();
    }

    private function setEnv()
    {
        $tab = include dirname(__DIR__,1)."/env.php";
        foreach($tab as $key => $value){
            $_ENV[$key] = $value;
        }
    }
}
