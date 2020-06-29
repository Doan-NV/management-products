<?php
    $router = new controller_libary_router();
    $user =  new controller_libary_loginController();
    $user->logout();
    // $url = $router->createUrl('login');
    $router->loginPage();
?>