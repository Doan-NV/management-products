<?php
$router = new controller_libary_router();
$user = new controller_libary_loginController();
$userPre = new model_User();

$id = $user->getID();
// $name = $_SESSION['name'];
// $email = $_SESSION['email'];
// $imagePre = $_SESSION['image'];

$profile = $userPre->addQueryParameter([
    "SELECT" => "*",
    "WHERE" => "id = ".$id
])->select();

if($router->getPOST('upload')){
    // đường dẫn hình ảnh
    $target =  "view/images/".basename($_FILES['image']['name']);
    $image = $_FILES['image']['name'];

    $userPre->image = $image;
    $userPre->id =$id;
    $userPre->updateAvata();

    if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
        $msg = " success";
    }else{
        $smg = " have pronlems";
    }
    $url = $router->createUrl('view/auth/profile');
    header("Location: $url");
}
?>