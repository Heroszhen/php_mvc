<?php

use src\Controller;
use src\Controller\Admin;

return [
    ['GET', '/', [], new Controller\HomeController(), "index"],
    //['POST', '/familiers/', ['\d+'], Controller\FamilierController::class, "editFamilier"],
];

