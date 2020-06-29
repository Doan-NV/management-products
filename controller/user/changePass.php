<?php

$router = new controller_libary_router();
$user = new controller_libary_loginController();
$userPre = new model_User();


$id = $user->getID();
$profile = $userPre->addQueryParameter([
    "SELECT" => "password",
    "WHERE" => "id = " . $id
])->select();
// var_dump($profile);

$message = "";
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$password =  test_input($router->getPOST('password'));
$newPassword =  test_input($router->getPOST('newpassword'));
$cfPassword =  test_input($router->getPOST('cfpassword'));
// var_dump($password, $newPassword, $cfPassword);
// die();

// $uppercase = preg_match('@[A-Z]@', $newPassword);
$lowercase = preg_match('@[a-z]@', $newPassword);
$number    = preg_match('@[0-9]@', $newPassword);

if (!$lowercase || !$number || strlen($newPassword) < 6) {
    $message = "mật khẩu phải có ít nhất 6 kí tự bao gồm chữ và số";
    echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/changePass') . "'>  OK</a></h2>";
} else {
    if ($password == "" || $newPassword == "" || $cfPassword == "") {
        $message = "không được để trống các trường";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/changePass') . "'>  OK</a></h2>";
    } else if ($password != $profile['password']) {
        $message = "mật khẩu không đúng";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/changePass') . "'>  OK</a></h2>";
    } else if ($newPassword == $profile['password']) {
        $message = "mật khẩu mới không được giống mật khẩu cũ";
        echo "<h2 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/changePass') . "'>  OK</a></h2>";
    } else if ($cfPassword != $newPassword) {
        $message = "hmm, nhập từ từ thôi, mật khẩu không trùng nhau kìa. ";
        echo "<h2 style='position: absolute;left: 25%;top: 15%; z-index:1; color: tomato'>" . $message . "<a href='" . $router->createUrl('view/auth/changePass') . "'>  OK</a></h2>";
    } else {
        $userPre->password = $newPassword;
        $userPre->id = $id;
        $userPre->updatePassword();
        $url = $router->createUrl('view/auth/profile');
        header("Location: $url");
    }
}
