<?php

$router = new controller_libary_router();
$user = new controller_libary_loginController();
$userPre = new model_User();


$message = "";
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$username = test_input($router->getPOST('username'));
$email = test_input($router->getPOST('email'));
// var_dump($username,$email);

if($username == "" || $email == ""){
    $message = "không được để trống các trường";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/forgotPass') . "'>  OK</a></h2>";
}else{
    // $userPre->username = $username;
    // $userPre->email = $email;
    
    $dataUser =  $userPre->addQueryParameter([
        "SELECT" => "id",
        "WHERE" => "username = '".$username."' AND email = '".$email."'"
    ])->select();
    if(isset($dataUser)){
        $url = $router->createUrl('view/auth/changePassAfterForgot',['id' => $dataUser['id']]);
        header("Location: $url");
    }else{
        $message = "Người Dùng Không Tồn Tại";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/forgotPass') . "'>  OK</a></h2>";
    }
}