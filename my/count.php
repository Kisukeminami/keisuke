<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');
session_start();
session_regenerate_id(true);
require_once('../dbc/sraff_dbc.php');
var_dump($_POST['max']);
echo "<br>";
var_dump($_POST);
echo "<br>";

$max=$post['max'];
for($i=0;$i<$max;$i++){
    $count[]=$post['count'.$i];
    echo $i;
    var_dump($count);
    echo "<br>";

}
$cart=$_SESSION['cart'];
for($i=$max;0<=$i;$i--){
    if(isset($post['delete'.$i])==true){
        array_splice($cart,$i,1);      
        array_splice($count,$i,1);

    }
}
$_SESSION['cart']=$cart;
$_SESSION['count']=$count;
var_dump($_SESSION["cart"]);
echo "<br>";
var_dump($_SESSION["count"]);
header('Location:shop_cart_list.php');
exit();
