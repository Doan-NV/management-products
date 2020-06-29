<?php
    spl_autoload_register(function($classname){
        // die($classname);
        $url = str_replace("_" , "/" , $classname);
        $path  = str_replace("controller","",dirname(__FILE__));
        // die($path."/".$url.".php");
        include_once $path."/".$url.".php";
    });
?>