<?php
$router = new controller_libary_router();
$user = new controller_libary_loginController();
$userPre = new model_User();
if($_SESSION == null){
    $router->loginPage();
}

$id = $user->getID();
$profile = $userPre->addQueryParameter([
    "SELECT" => "*",
    "WHERE" => "id = " . $id
])->select();



?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile Card</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/category.css"> -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <style>
        <?php
        include './frontend/css/profile.css';
        include './frontend/css/category.css'
        ?>
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-sm-10">
                    <a href="<?php echo $router->createUrl('view/home') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Trở Về Trang Chủ</a>
                </div>
                <div class="col-sm-2">
                    <a href="<?php echo $router->createUrl('view/auth/logout') ?>" type="button" class="btn btn-outline-secondary">Đăng Xuất</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-container">
        <div class="upper-container">
            <div class="image-container">
                <img src="<?php echo "http://127.0.0.1:8887/" . $profile['image']; ?>" />
            </div>
        </div>
        <div class="lower-container">
            <div>
                <form action="<?php echo $router->createUrl('controller/user/uploadAvatar') ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control-files" id="exampleFormControlFile1" name="image">
                        <br>
                        <input type="submit" value="Thêm Ảnh Đại Diện" class="btn btn-primarys" name="upload">
                    </div>
                </form>
                <h3><?php echo $profile['name'] ?></h3>
                <h4><?php echo $profile['email'] ?></h4>
            </div>
            <div>
                <p>sodales accumsan ligula. Aenean sed diam tristique,
                    fermentum mi nec, ornare arch.
                </p>
            </div>
            <div>
                <a href="<?php echo $router->createUrl('view/auth/changePass')?>" class="btn">Thay đổi mật khẩu</a>
            </div>
        </div>
    </div>
</body>

</html>