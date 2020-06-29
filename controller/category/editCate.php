<?php
        $router = new controller_libary_router();
        $category = new model_Category();
        $user = new controller_libary_loginController();

        var_dump($_GET['id']);
        $id =  (int) $_GET['id'];
        $id_user = (int) $_SESSION['id'];
    
        $valueOfId = $category->addQueryParameter([
            "SELECT" => "name",
            "WHERE" => "id = ".$id
        ])->selectOne();
        var_dump($valueOfId);
    
        function test_input($data)
        {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }
    
        $name = test_input($router->getPOST('name'));
    
        if($router->getPOST('submit') && $name){
            $category->id = $id;
            $category->name = $name;
            $category->id_user = $id_user;
            $category->update();
            $url = $router->createUrl('view/home');
            header("location: $url");
        }

?>