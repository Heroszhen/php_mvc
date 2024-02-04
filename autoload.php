<?php

spl_autoload_register(function($classname){
    require_once __DIR__.DIRECTORY_SEPARATOR.str_replace('\\',DIRECTORY_SEPARATOR,$classname).".php";
});