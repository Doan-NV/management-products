<?php
// session_start();
$router =  new controller_libary_router();
$category = new model_Category();
$product =  new model_Product();
$user = new controller_libary_loginController();

$id_user = (int) $user->getID();
// giá trị id của loại sản phảm được truyển qua get
$id_cate = (int) $_GET['id_cate'];

// lấy các bản ghi của loại sản phẩm
$cate = $category->addQueryParameter([
    "SELECT" => "id, name",
    "WHERE" => "id_user = " . $id_user
])->select();

// lấy loại snar phẩm hiện tại
$catePre = $category->addQueryParameter([
    "SELECT" => "id, name ,id_user",
    "WHERE" => "id = " . $id_cate
])->selectOne();

// lấy số lượng sản phẩm của loại sản phẩm
$count  = $product->addQueryParameter([
    "SELECT" => "id",
    "WHERE" => "id_cate = " . $id_cate
])->selectCount(); // number


// phân trang sản phẩm tránh tình trạng lấy quá nhiều bản ghi mất thời gian tải dữ liệu
$pageno;
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$i = 1;
$perpage = 6; // số lượng bản ghi hiện thị mỗi trang
$offset = ($pageno - 1) * $perpage; // bỏ qua n bản ghi khi chuyển từ trang số 2
$total_pages = ceil($count / $perpage);


$dataName = "";
$dataQuantity = "";
$sort = 0;
$label = "";

if (isset($_GET['sort'])) {
    $sort = (int) $_GET['sort'];
} else {
    $sort = 0;
}

if ($sort == 0) {
    // lấy lượng sản phẩm để hiện thị : offset - limit
    $label = " Số Lượng: ";
    $record = $product->addQueryParameter([
        "SELECT" => '*',
        "WHERE" => 'id_cate =' . $id_cate,
        "OTHER" => "$offset,$perpage"
    ])->selectRecord();
    // var_dump($record);
    if ($record != null) {
        foreach ($record as $value) {
            $dataName = $dataName . "'" . $value['name'] . "',";
            $dataQuantity = $dataQuantity . $value['quantity'] . ",";
        }
    }
} else if ($sort == 1) {
    $label = "Đã Bán: ";
    $record = $product->addQueryParameter([
        "SELECT" => '*',
        "WHERE" => 'id_cate =' . $id_cate . " ORDER BY productssold DESC ",
        "OTHER" => "$offset,$perpage"
    ])->selectRecord();
    // var_dump($record);
    foreach ($record as $value) {
        $dataName = $dataName . "'" . $value['name'] . "',";
        $dataQuantity = $dataQuantity . $value['productssold'] . ",";
    }
} else {
    $label = "Giá: ";
    $record = $product->addQueryParameter([
        "SELECT" => '*',
        "WHERE" => 'id_cate =' . $id_cate . " ORDER BY price DESC ",
        "OTHER" => "$offset,$perpage"
    ])->selectRecord();
    // var_dump($record);
    foreach ($record as $value) {
        $dataName = $dataName . "'" . $value['name'] . "',";
        $dataQuantity = $dataQuantity . $value['price'] . ",";
    }
}

$dataName = trim($dataName, ",");
$dataQuantity =  trim($dataQuantity, ",");
// var_dump($dataName,$dataQuantity);
// die();

?>
<?php if ($id_user == (int) $catePre['id_user']) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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

        <script src="./frontend/js/action.js"></script>
        <style>
            <?php include './frontend/css/category.css' ?>
        </style>

    </head>
    <!-- 0163 892 5398 -->

    <body>
        <section>
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
                <div class="chart">
                    <?php echo '<h3>biểu đổ hiển thị số lượng ' . $catePre['name'] . ' được bán trong thời gian vừa qua</h3>'; ?>
                    <canvas id="myChart"></canvas>
                </div>
                <div class="section-1">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="name-product">
                                <h4>Kho Lưu Trữ</h4>
                                <a href="<?php echo $router->createUrl('view/cate/addCate') ?>" type="button" class="btn btn-info">New</a>
                                <br>
                                <div class="search">
                                    <!-- <form action="" method="POST"> -->
                                    <!-- <input class="form-control form-control-sm" type="text" id="fname" name="fname" onkeyup="showHint(this.value)"> -->
                                    <input type="text" name="search_text" id="search_text" placeholder="Search Product Details" class="form-control" />
                                    <!-- </form> -->
                                </div>
                                <p><span id="result"></span></p>
                                <div class="project">
                                    <?php
                                    foreach ($cate as $value) {
                                        echo '<h4><a href="' . $router->createUrl('view/cate/productOfCate', ['id_cate' => $value['id']]) . '">' . $value['name'] . '</a></h4>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-2">
                                    <?php echo '<h4 style = "color: green">' . $catePre['name'] . '</h4>'; ?>
                                </div>
                                <div class="col-sm-3">
                                    <a href="<?php echo $router->createUrl('view/products/newProduct', ['id_cate' => $id_cate,'pageno' => $pageno]) ?>" type="button" class="btn btn-info">Thêm Sản Phẩm</a>
                                </div>
                                <div class="col-sm-7">
                                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                        <h5 class="navbar-brand">Sắp xếp theo</h5>
                                        <div class="collapse navbar-collapse" id="navbarNav">
                                            <ul class="navbar-nav">
                                                <li class="nav-item active">
                                                    <h5> <a class="nav-link" href="<?php echo $router->createUrl('view/cate/productOfCate', ['id_cate' => $id_cate,'pageno' => $pageno]) ?>">Mặc định</a></h5>
                                                </li>
                                                <li class="nav-item">
                                                    <h5><a class="nav-link" href="<?php echo $router->createUrl('view/cate/productOfCate', ['id_cate' => $id_cate, 'sort' => 1,'pageno' => $pageno]) ?>">Bán Chạy</a></h5>
                                                </li>
                                                <li class="nav-item">
                                                    <h5><a class="nav-link" href="<?php echo $router->createUrl('view/cate/productOfCate', ['id_cate' => $id_cate, 'sort' => 2,'pageno' => $pageno]) ?>">Giá Giảm Dần</a></h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>

                            </div>
                            <div class="row">
                                <?php
                                if ($record) {
                                    foreach ($record as $value) {
                                        echo '<div class="product">';
                                        echo    '<h2>' . $value['name'] . '</h2>';
                                        echo    '<img class="align-self-center mr-3" src="http://127.0.0.1:8887/' . $value['image'] . '">';
                                        echo    '<h3>giá: ' . $value['price'] . '$</h3>';
                                        echo    '<h5>còn lại: ' . $value['quantity'] . '</h5>';
                                        echo    '<h6>đã bán: .' . $value['productssold'] . '</h6>';
                                        echo    '<a href="' . $router->createUrl('view/products/editProduct', ['id' => $value['id'], 'pageno' => $pageno]) . '" class="btn btn-outline-warning">Sửa</a>';
                                        echo    '<a href="' . $router->createUrl('controller/product/delete', ['id' => $value['id'], 'pageno' => $pageno]) . '" class="btn btn-outline-danger delete">Xóa</a>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<h2>no product for category</h2>';
                                }
                                ?>
                                <!-- <img src="./45bf96099293ac9b545fe2f4db63b2a9_tn.jpg" alt=""> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="container">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center" style="margin-left: 205px">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php
                    while ($i <= $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="' . $router->createUrl('view/cate/productOfCate', ['id_cate' => $id_cate, 'pageno' => $i,'sort' => $sort]) . '">' . $i . '</a></li>';
                        $i++;
                    }
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </footer>
        <a class="on_top" href="#"><i class="fa-arrow-circle-up fa"></i></a>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $dataName; ?>],
                    datasets: [{
                        label: '<?php echo $label; ?>',
                        data: [<?php echo $dataQuantity; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 159, 64, 0.4)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 159, 64, 0.8)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 159, 64, 0.4)',
                            'rgba(255, 159, 64, 0.6)',

                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
    </body>

    </html>
<?php } else { ?>
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

<?php } ?>