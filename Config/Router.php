<?php

namespace Config;

use vendor\framework\Request;
use src\Service\JWTService;

class Router
{
    private $routes = [];

    public function setRoutes()
    {
        $this->routes = include dirname(__DIR__).'/Config/Routes.php';
    }

    public function getRouter()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $url = $_SERVER["REQUEST_URI"];

        //$this->checkAccess($url);

        if ($_ENV["maintenance"] === true) {
            if ($url !== "/maintenance") {
                header("Location: /maintenance");
            } 
        } 

        $index = $this->searchRoute($method, $url);
        if($index != -1){
            $route = $this->routes[$index];
            $parameters = [];
            if(count($route[2]) > 0){
                $tab = explode('/',$url);
                $last = array_pop($tab);
                $tab = explode("_",$last);
                foreach($tab as $value)$parameters[] = $value;
            }
            call_user_func_array([new $route[3](),$route[4]], $parameters);
        }
    }

    public function searchRoute(string $method, string $url):int
    {
        $index = -1;
        foreach($this->routes as $key=>$value){
            if(strtolower($value[0]) == strtolower($method)){//compare methods
                if(count($value[2]) == 0){
                    if($value[1] == $url){
                        $index = $key;
                        break;
                    }
                }else{//compare stocked routes and url
                    $exp = $value[1];
                    $exp = str_replace("/", "\/", $exp, $count);
                    foreach($value[2] as $key2=>$value2){
                        if($key2 < count($value[2]) - 1)$exp .= $value2 . "_";
                        else $exp .= $value2;
                    }
                    $exp = '/^('.$exp.')$/';
                    preg_match($exp, $url, $matches);
                    if(count($matches) > 0){
                        $index = $key;
                        break;
                    }
                }
            }
        }

        return $index;
    }

    public function checkAccess(string $url): void
    {
        $request = new Request();
        if($request->isXmlHttpRequest()) {
            if(
                strpos($url, "/profile") === false && 
                strpos($url, "/admin") === false
            ){
                return;
            }
            $rights = include dirname(__DIR__).'/Config/security.php';
            $auth = $request->getAuthorization();
            $jwtService = new JWTService();
            $token = $jwtService->extractToken($auth);
            if($token === ""){
                $this->sendErrorResponse();
            }
            $user = $jwtService->getUserByToken($token);
            if($user === null){
                $this->sendErrorResponse();
            }
            foreach($rights as $key => $right){
                $cutUrl = substr($url, 0, strlen($key));
                if($key === $cutUrl){
                    $result = array_intersect($right, $user["roles"]);
                    if(count($result) === 0){
                        $this->sendErrorResponse();
                    }
                }
            }
        }
    }

    private function sendErrorResponse():void
    {
        echo json_encode(['status' => -1]);
        exit;
    }
}