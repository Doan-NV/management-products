<?php
// http://localhost/manager/index.php?id_cate=4&r=view%2Fcate%2FproductOfCate
    // session_start();
    $router = new controller_libary_router();
    $product = new model_Product();
    $category = new model_Category();
    $user = new controller_libary_loginController();

    $id_user = $user->getID();
    // var_dump($id_user);
    $id = (int) $_GET['id']; // 32
    if(isset($_GET['pageno'])){
        $pageno = (int) $_GET['pageno'];
    }else{
        $pageno = 1;
    }
    // var_dump("id sản phẩm: ".$id);
    // lấy dữ liệu của sản phẩm cần sửa hiển thị ra form
    $productEdit =  $product->addQueryParameter([
        "SELECT" => "*",
        "WHERE" => " id = ".$id
    ])->selectOne();
    // var_dump('id cate trong sản phẩm :'.$productEdit['id_cate']);
    // lấy dứ liệu của trường id, name (category) hiện thị ra form và đẩy vào get
    $cate = $category->addQueryParameter([
        "SELECT" => "id,name,id_user",
        "WHERE" => " id = ". (int)$productEdit['id_cate']
    ])->selectOne();
    // var_dump($cate['id_user']);
    // var_dump($id_user, (int) $cate['id_user'] );
    // die();
?>
<?php if($id_user == (int) $cate['id_user'] ) {?>
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
                    <a href="<?php echo $router->createUrl("view/cate/productOfCate",['id_cate' => $productEdit['id_cate'],'pageno' => $pageno])?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Trở về Trang Trước</a>
                </div>
                <div class="col-sm-2">
                    <a href="index.html" type="button" class="btn btn-outline-secondary">Đăng Xuất</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
                <br>
                <br>
                <div class="title">
                    <h2>Sửa Sản Phẩm</h2>
                </div>
                <form action="<?php echo $router->createUrl('controller/product/editProduct',['id' => $productEdit['id'],'id_cate' =>$productEdit['id_cate'],'pageno' => $pageno])?>" method="POST" enctype="multipart/form-data">

                    <div class="form-group" >
                    <label for="inputName">ID</label>
                      <input class="form-control form-control-lg" id="inputName" type="text" disabled value="<?php echo $id?>" name = "id">
                      <label for="inputName">Tên Sản Phẩm</label>
                      <input class="form-control form-control-lg" id="inputName" type="text" value="<?php echo $productEdit['name']?>" name = "name">
                      <br>
                      <label for="quantity">Số Lượng</label>
                      <input class="form-control form-control-lg" id="quantity" type="number" value="<?php echo $productEdit['quantity']?>" name = "quantity">
                      <br>
                      <label for="price">Giá Bán</label>
                      <input class="form-control form-control-lg" id="price" type="number" value="<?php echo $productEdit['price']?>" name="price">
                      <br>
                      <label for="category">Loại Sản Phẩm</label>
                      <input class="form-control form-control-lg" id="category" type="text" disabled value="<?php echo $cate['name']?>" name = "category">
                      <br>
                      <label for="exampleFormControlFile1">Ảnh Sản Phẩm</label>
                      <input type="file" class="form-control-file" id="exampleFormControlFile1" name = "image">
                      <br>
                      <input type="submit" value="Thêm mới" class="btn btn-primary" name = 'submmit'>
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
    <h1 style='position: absolute;left: 36%;top: 15%; z-index:1; color: tomato'>Bạn không có quyền thực hiện thay đổi này  <a href="<?php echo $router->createUrl("view/cate/productOfCate", ['id_cate' => $cate['id']])?>">  OK </a></h1>
    </body>

<?php }?> 