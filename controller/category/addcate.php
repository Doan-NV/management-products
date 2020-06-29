<?php
    // $abc = $_POST['name'];
    // var_dump($abc);
    // die();
    $router = new controller_libary_router();
    $category = new model_Category();
    $user = new controller_libary_loginController();

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = test_input($router->getPOST('name'));
    $category->name = $name;
    $category->id_user = (int) $user->getID();
    if($name != ""){
        $category->insert();
        $url = $router->createUrl('view/home');
        header("location: $url");
    }

