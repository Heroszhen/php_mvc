<?php

namespace src\Controller;

use Config\AbstractController;

class HomeController extends AbstractController{

    public function index()
    {
        
        return $this->render("home/index.php",[
           
        ]);
    }

}