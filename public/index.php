<?php

require_once "../autoload.php";

use Config\Kernel;

session_start();

$kernel = new Kernel();
$kernel->run();

