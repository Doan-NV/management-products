<?php
    // session_start();
    $router = new controller_libary_router();
    $product = new model_Product();
    $category = new model_Category();
    $user = new controller_libary_loginController();
    $id_user = (int) $user->getID();
    
    $id_cate = (int) $_GET['id_cate'];
    $pageno = (int) $_GET['pageno'];
    // checking data func
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // lấy dữ liệu đổ ra form
    $catePre = $category->addQueryParameter([
        "SELECT" => "id, name, id_user",
        "WHERE" => "id = ".$id_cate
    ])->selectOne();
    // var_dump($catePre);
    // die();
    // var_dump($id_user,$catePre['id_user']);
    // die();
    $check;
    if($id_user == (int)$catePre['id_user']){
        $check = 1;
    }else{
        $check = null;
    }
    $name = test_input($router->getPOST('name'));
    $quantity = test_input($router->getPOST('quantity'));
    $price = test_input($router->getPOST('price'));
    $category = $catePre['name'];
    $msg = "";

    if($router->getPOST('upload') && $name && $quantity && $price){
        // đường dẫn hình ảnh
        $target =  "view/images/".basename($_FILES['image']['name']);
        $image = $_FILES['image']['name'];

        $product->name = $name;
        $product->cate_id = $id_cate;
        $product->price = $price;
        $product->quantity = $quantity;
        $product->product_sold = 0;
        $product->image = $image;
        $product->insert();

        if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
            $msg = " success";
        }else{
            $smg = " have pronlems";
        }

        // content

    }

?>
<?php if($check){?>
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
    <!-- <link rel="stylesheet" href="./manager/frontend/css/category.css"> -->
    <style><?php include '../frontend/css/category.css';?></style>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    <div class="container">
        <br>
        <br>
        <div class="header">
            <div class="row">
                <div class="col-sm-10">
                    <a href="<?php echo $router->createUrl("view/cate/productOfCate",["id_cate" => $id_cate, 'pageno' => $pageno]); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Trở về Trang Trước</a>
                </div>
                <div class="col-sm-2">
                    <a href="<?php echo $router->createUrl('view/auth/logout')?>" type="button" class="btn btn-outline-secondary">Đăng Xuất</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-5">

                <div class="title">
                    <h2>Thêm mới Sản Phẩm</h2>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="inputName">Tên Sản Phẩm</label>
                      <input class="form-control form-control-lg" id="inputName" type="text" placeholder="Tên Sản Phẩm" name ="name">
                      <br>
                      <label for="quantity">Số Lượng</label>
                      <input class="form-control form-control-lg" id="quantity" type="number" placeholder="Số Lượng" name="quantity">
                      <br>
                      <label for="price">Giá Bán</label>
                      <input class="form-control form-control-lg" id="price" type="number" placeholder="Giá Bán" name="price">
                      <br>
                      <label for="category">Loại Sản Phẩm</label>
                      <input class="form-control form-control-lg" id="category" type="text" disabled value="<?php echo $catePre['name'];?>" name="category">
                      <br>
                      <label for="exampleFormControlFile1">Ảnh Sản Phẩm</label>
                      <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                      <br>
                      <input type="submit" value="Thêm mới" class="btn btn-primary" name="upload">
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
    <h1 style='position: absolute;left: 36%;top: 15%; z-index:1; color: tomato'>Bạn không có quyền truy cập vào đây <a href="<?php echo $router->createUrl("view/cate/productOfCate",['id_cate' => $id_cate])?>">  OK</a></h1>
    </body>

<?php }?>