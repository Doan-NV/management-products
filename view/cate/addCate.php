<?php
// session_start();
$router = new controller_libary_router();
$user = new controller_libary_loginController();

$id_user = $user->getID();
// var_dump($id_user);
// die();
?>
<?php if($_SESSION) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/category.css"> -->
    <style><?php include "./frontend/css/home.css"?></style>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-sm-10">
                    <a href="<?php echo $router->createUrl('view/home')?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Trở về Trang Chủ</a>
                </div>
                <div class="col-sm-2">
                    <a href="<?php echo $router->createUrl('view/auth/logout')?>" type="button" class="btn btn-outline-secondary">Đăng Xuất</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-5">

                <div class="title">
                    <h2>Thêm Loại Sản Phẩm</h2>
                </div>
                <form action="<?php echo $router->createUrl('controller/category/addcate')?>" method="POST">

                    <div class="form-group">
                      <label for="inputName">Tên Loại Sản Phẩm</label>
                      <input class="form-control form-control-lg" id="inputName" type="text" placeholder="Tên Loại Sản Phẩm" name="name">
                      <br>
                      <input type="submit" value="Thêm" class="btn btn-primary" name ="submit">
                    </div>
                  </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php }else {?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            <?php include './frontend/css/home.css' ?>
        </style>
    </head>
    <body>
    <h1 style='position: absolute;left: 36%;top: 15%; z-index:1; color: tomato'>Bạn không có quyền thực hiện<a href="<?php echo $router->createUrl("view/home")?>">  OK</a></h1>
    </body>

<?php }?> 
