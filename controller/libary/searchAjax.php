<?php
// var_dump($_SESSION);
include '../autoload.php';

$user =  new controller_libary_loginController();
$product =  new model_Product();
$category = new model_Category();
$router =  new controller_libary_router();

$id_user = (int) $_SESSION['id'];

var_dump($_GET);
$output = '';
$data;


if(isset($_POST["query"])){
  $temp = $_POST["query"];
  $data = $category->addQueryParameter([
    "SELECT" => "products.name, products.id ",
    "OTHER" => " INNER JOIN users ON users.id=categories.id_user AND users.id = ".$id_user."  
    INNER JOIN products ON categories.id = products.id_cate AND products.name LIKE '%".$temp."%'"
  ])->select();
  // var_dump($data); 
}

if(isset($data)){
 $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
 ';
 foreach($data as $value){
  $output .= '
   <tr>
    <td><a href = "http://localhost/manager/index.php?id='.$value['id'].'&r=view%2Fproducts%2FeditProduct" style = "float: left ">'.$value["name"].'</a></td>
   </tr>
  ';
 }
 echo $output;
}else{
 echo 'Data Not Found';
}
 
?>