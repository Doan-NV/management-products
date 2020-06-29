<?php
    include './controller/autoload.php';

    $router = new controller_libary_router(__DIR__);
    $router->router();
?>
