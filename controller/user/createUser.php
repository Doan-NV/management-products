<?php
    $router = new controller_libary_router();
    $user =  new model_User();
    
    $message = "";
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
   
    $fullname = test_input($router->getPOST('fullname'));
    $username =  test_input($router->getPOST('username'));
    $password =  test_input($router->getPOST('password'));
    $cfpassword =  test_input($router->getPOST('cfpassword'));
    $email =  test_input($router->getPOST('email'));

    // $uppercase = preg_match('@[A-Z]@', $newPassword);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    $userChecking = $user->addQueryParameter([
        "SELECT" => "username",
        "WHERE" => "username = '".$username."'"
    ])->select();
    
    if(!$lowercase || !$number || strlen($password) < 6){
        $message = "Mật khẩu phải nhiều hơn 6 kí tự bao gồm chữ và số";
        echo "<h2 style='position: absolute;left: 35%;top: 15%; z-index:1; color: tomato'>".$message."<a href='".$router->createUrl('view/auth/createUser',['fullname' => $fullname, 'username' => $username, 'email' => $email ])."'>  OK</a></h2>";
    }else if($fullname == null){
        $message = "Name is null";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>".$message."<a href='".$router->createUrl('view/auth/createUser',['fullname' => $fullname, 'username' => $username, 'email' => $email ])."'>  OK</a></h2>";
    }else if ($userChecking || $username == null) { 
        $message = "Username available or null";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>".$message."<a href='".$router->createUrl('view/auth/createUser',['fullname' => $fullname, 'username' => $username, 'email' => $email ])."'>  OK</a></h2>";
    }else if($password != $cfpassword) {
        $message = "password is incorrect";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>".$message."<a href='".$router->createUrl('view/auth/createUser',['fullname' => $fullname, 'username' => $username, 'email' => $email ])."'>  OK</a></h2>";
    }else{
        $user->username = $username;
        $user->password = $password;
        $user->email = $email;
        $user->fullname = $fullname;
        $user->insert();
        $router->loginPage();
    }

    // $url = $router->createUrl('view/home');
    // header("location: $url");
