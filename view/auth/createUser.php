<?php
$router = new controller_libary_router();
$fullname = "";
$username = "";
$email = "";
$password = "";
$cfpassword = "";
if ($_GET['fullname']) {
  $fullname = $_GET['fullname'];
}
if ($_GET['username']) {
  $username = $_GET['username'];
}
if ($_GET['email']) {
  $email = $_GET['email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="./css/signup.css"> -->
  <style>
    <?php include './frontend/css/signup.css' ?>
  </style>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="createuser">Đăng Kí Tài Khoản</h1>
        <p class="login"><a href="<?php echo $router->createUrl('view/auth/login')?>">Đăng Nhập</a></p>
      </div>
      <div class="col-sm-6">
        <form action="<?php echo $router->createUrl('controller/user/createUser') ?>" class="login-form" method="POST">
          <h2>Đăng Kí Tài Khoản</h2>

          <div class="txtb">
            <input type="text" name="fullname" value="<?php echo $fullname ?>">
            <span data-placeholder="Full Name"></span>
          </div>
          <div class="txtb">
            <input type="text" name="username" value="<?php echo $username ?>">
            <span data-placeholder="Username"></span>
          </div>


          <div class="txtb">
            <input type="password" name="password">
            <span data-placeholder="Password"></span>
          </div>

          <div class="txtb">
            <input type="password" name="cfpassword">
            <span data-placeholder="Confirm Password"></span>
          </div>
          <div class="txtb">
            <input type="text" name="email" value="<?php echo $email ?>">
            <span data-placeholder="Email"></span>
          </div>

          <input type="submit" class="logbtn" value="Tạo" name="create">

        </form>

        <script type="text/javascript">
          $(".txtb input").on("focus", function() {
            $(this).addClass("focus");
          });

          $(".txtb input").on("blur", function() {
            if ($(this).val() == "")
              $(this).removeClass("focus");
          });
        </script>
      </div>
    </div>
  </div>
</body>

</html>