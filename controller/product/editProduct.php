<?php
$router = new controller_libary_router();
$product = new model_Product();
$category = new model_Category();

$id = (int) $_GET['id'];
$id_cate = (int) $_GET['id_cate'];
$pageno = (int) $_GET['pageno'];
// var_dump($id_cate);
// die();

// checking data func
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$productEdit =  $product->addQueryParameter([
    "SELECT" => "image",
    "WHERE" => "id = " . $id
])->selectOne();

$catePre = $category->addQueryParameter([
    "SELECT" => "id, name",
    "WHERE" => "id = " . $id_cate
])->selectOne();
// var_dump($catePre);
// die();

$name = test_input($router->getPOST('name'));
$quantity = test_input($router->getPOST('quantity'));
$price = test_input($router->getPOST('price'));
$category = $catePre['name'];
$msg = "";
// var_dump($name,$quantity,$price,$category);
// die();
$target =  "view/images/" . basename($_FILES['image']['name']);
$image = $_FILES['image']['name'];

// kiểm tra người dùng có uploadfile lên không?
$image == "" ? $image = $productEdit['image'] : $image;

$product->id = $id;
$product->name = $name;
$product->cate_id = (int) $id_cate;
$product->price = (int) $price;
$product->quantity = (int) $quantity;
// $product->product_sold = 0;
$product->image = $image;

$product->update();

if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    $msg = " success";
} else {
    $smg = " have pronlems";
}
$url = $router->createUrl('view/cate/productOfCate', ['id_cate' => $id_cate,'pageno' => $pageno]);
header("location: $url");
