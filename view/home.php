<?php
$router = new controller_libary_router();
$user = new controller_libary_loginController();
$categories = new model_Category();
// var_dump($_SESSION);
$id_user;
if (isset($_SESSION)) {
    $id_user = (int) $_SESSION['id'];
} else {
    $id_user = "";
}

$listCate = $categories->addQueryParameter([
    "SELECT" => "*",
    "WHERE" => "id_user = " . $id_user
])->select();
?>

<?php if ($_SESSION) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="./css/home.css"> -->
        <style>
            <?php include './frontend/css/home.css' ?>
        </style>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    </head>
    <!-- 0163 892 5398 -->

    <body>
        <section>
            <div class="container">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h1>Xin Chào, <a href="<?php echo $router->createUrl('view/auth/profile') ?>"><?php echo $user->getSESSION('name') ?></a></h1>
                        </div>
                        <div class="col-sm-2">
                            <a href="<?php echo $router->createUrl("view/auth/logout"); ?>" class="btn btn-outline-secondary">Đăng Xuất</a>
                        </div>
                    </div>
                </div>
                <div class="table-category">
                    <div class="title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>Danh Sách Loại Hàng Hóa</h3>
                            </div>
                            <div class="col-sm-4">
                                <h4><a class="btn btn-outline-info" href="<?php echo $router->createUrl('view/cate/addCate') ?>">Thêm Loại Hàng Hóa</a></h4>
                            </div>
                        </div>
                    </div>
                    <?php if ($listCate != null) { ?>
                        <table class=" table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($listCate != null) {
                                    foreach ($listCate as $value) {
                                        echo "<tr>";
                                        echo     '<th scope="row">' . $value["id"] . '</th>';
                                        echo     "<td>";
                                        echo         '<h4><a class="" href="' . $router->createUrl('/view/cate/productOfCate', ['id_cate' => $value['id']]) . '">' . $value['name'] . '</a></h4>';
                                        echo     "</td>";
                                        echo     '<td><a class="btn btn-info" href="' . $router->createUrl('view/cate/changeCate', ['id' => $value['id']]) . '">Edit</a></td>';
                                        echo     '<td><a class="btn btn-success" href="' . $router->createUrl('controller/category/delete', ['id' => $value['id']]) . '">Delete</a></td>';
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                </div>
                <a class="on_top" href="#"><i class="fa-arrow-circle-up fa"></i></a>
    </body>
    </html>
<?php 
} else {
    echo "<h1>Không có Loại Sản Phẩm Nào</h1>";
    }} else {
     $router->loginPage();
} ?>