<?php
    $category = new model_Category();
    $product = new model_Product();
    $router = new controller_libary_router();
    $id = $_GET['id'];
    $id_cate = $_GET['id'];
    var_dump($id);
    $product->cate_id = $id;
    $product->deleteAll();
    $category->id = $id;
    $category->delete();
    $url = $router->createUrl('view/home');
    header("Location: $url");
?>