<?php

$router = new controller_libary_router();
$fullname = "";
$email = "";
$username = "";

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$username = test_input($router->getPOST('username'));
$password = test_input($router->getPOST('password'));
$message = "";

$loginController = new controller_libary_loginController();

if ($router->getPOST('submit') && $username && $password ) {
  
  $loginController->username = $username;
  $loginController->password = $password;
  // đã nhận được giá trị rồi.

  # chạy vào login để thực hiện query từ giá trị form truyền vào
  $loginController->login();

  // die();
  if ($loginController->isLogin()) {
    $router->homePage();
  } else {
    $message = "username or password is incorrect";
    echo "<h5 style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>$message</h5>";
  }
}
if($loginController->isLogin()){
  $router->homePage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="./css/style.index.css"> -->
  <style>
    <?php include './frontend/css/login.css' ?>
  </style>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="title">
      <h1 class="title-header">Welcome To freemanagement.com </h1>
    </div>
    <form action="<?php echo $router->createUrl('view/auth/login')?>" class="login-form" method="POST">
        <h1>Đăng Nhập</h1>

        <div class="txtb">
            <input type="text" name="username">
            <span data-placeholder="Tên Đăng Nhập"></span>
        </div>

        <div class="txtb">
            <input type="password" name="password">
            <span data-placeholder="Mật Khẩu"></span>
        </div>

        <input type="submit" class="logbtn" value="Đăng Nhập" name ="submit">

        <div class="bottom-text">
            Đăng kí tài khoản <a href="<?php echo $router->createUrl('view/auth/createUser',['fullname' => $fullname, 'username' => $username, 'email' => $email ])?>">Tại đây</a>
            <br>
            <a href="<?php echo $router->createUrl('view/auth/forgotPass')?>">Quên Mật Khẩu</a>
        </div>
    </form>

  </div>
  <script type="text/javascript">
    $(".txtb input").on("focus", function() {
      $(this).addClass("focus");
    });

    $(".txtb input").on("blur", function() {
      if ($(this).val() == "")
        $(this).removeClass("focus");
    });
  </script>
</body>

</html>