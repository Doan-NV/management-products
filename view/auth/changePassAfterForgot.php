<?php
    $router = new controller_libary_router();
    $user = new controller_libary_loginController();
    $userPre = new model_User();
    
    
    $id = $_GET['id'];
    $message = "";
    
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    $newPassword =  test_input($router->getPOST('newpassword'));
    $cfPassword =  test_input($router->getPOST('cfpassword'));
    // var_dump($password, $newPassword, $cfPassword);
    // die();
    
    // $uppercase = preg_match('@[A-Z]@', $newPassword);
    $lowercase = preg_match('@[a-z]@', $newPassword);
    $number    = preg_match('@[0-9]@', $newPassword);
    if($router->getPOST('submit')){
        if (!$lowercase || !$number || strlen($newPassword) < 6) {
            $message = "mật khẩu phải có ít nhất 6 kí tự bao gồm chữ và số";
            echo "<p style='position: absolute;left: 38%;top: 15%; z-index:1; color: tomato'>" . $message . " </p>";
        }
        else {
            if ( $newPassword == "" || $cfPassword == "") {
                $message = "không được để trống các trường";
                echo "<p style='position: absolute;left: 42%;top: 15%; z-index:1; color: tomato'>" . $message . " </p>";
            } else if ($cfPassword != $newPassword) {
                $message = "hmm, nhập từ từ thôi, mật khẩu không trùng nhau kìa. ";
                echo "<p style='position: absolute;left: 37%;top: 15%; z-index:1; color: tomato'>" . $message . " </p>";
            } else {
                $userPre->password = $newPassword;
                $userPre->id = $id;
                $userPre->updatePassword();
                $url = $router->createUrl('view/auth/login');
                header("Location: $url");
            }
        }
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
        <form action="" class="login-form" method="POST">
            <h2>Thay Đổi Mật Khẩu</h2>

            <div class="txtb">
                <input type="password" name="newpassword">
                <span data-placeholder="Mật Khẩu Mới"></span>
            </div>

            <div class="txtb">
                <input type="password" name="cfpassword">
                <span data-placeholder="Xác Minh Mật Khẩu"></span>
            </div>

            <input type="submit" class="logbtn" value="Thay đổi" name="submit">

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