<?php
    $product = new model_Product();
    $category = new model_Category();
    $router = new controller_libary_router();


    $id = $_GET['id'];
    $pageno =$_GET['pageno'];
    var_dump($_GET);
    // die();


    var_dump($id);
    // lấy dư liệu trường id_cate để khi xóa xong nó trở về ngay chuyên mục của nó
    $id_cate = $product->addQueryParameter([
        "SELECT" => "id_cate",
        "WHERE" => "id = ".$id
    ])->selectOne();
    // var_dump($id_cate);

    $product->id = $id;
    $product->delete();
    $url = $router->createUrl('view/cate/productOfCate',['id_cate' => $id_cate['id_cate'],'pageno' => $pageno]);
    // var_dump($url);
    header("Location: $url");
?>