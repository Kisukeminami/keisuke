<?php 
require_once('../dbc/shop_dbc.php');

session_start();
session_regenerate_id(true);
$cart=$_SESSION['cart'];
$count=$_SESSION['count'];
$pass=$_SESSION['pass'];
var_dump($pass);
$max=count($cart);
$pdo=shop\dbconect();

$stmt=$pdo->prepare("SELECT `mail` FROM youser_sin WHERE pass=?");
$date[]=$pass;
$stmt->execute($date);
$youmail=$stmt->fetch(PDO::FETCH_ASSOC);
$mail=$youmail['mail'];
$stmt=null;

/*//flag =0の注文表を引っ張てくる。
$stmt = $pdo->prepare("SELECT `cood`,`quantiry`FROM `shop_order` WHERE mail AND flag=0");
$date[]=$mail;
$stmt->execute();
$result=$stmt->fetch();
$cood=$result[`cood`];
$quantiry=$result[`quantiry`];
$stmt=null;*/

//カートの商品コード分、商品個数を引っ張てくる。
foreach ($cart as $key=>$value) 
{
    $stmt = $pdo->prepare("SELECT `quantiry`FROM shop_list WHERE id=?");
    $date=array();
    $date[0]=$value;
    $stmt->execute($date);
    $disp_aitems=$stmt->fetch(PDO::FETCH_ASSOC);
    $disp_quantiry[]=$disp_aitems['quantiry'];     

}
$stmt=null;
var_dump($disp_quantiry);
for ($i=0;$i<$max;$i++) 
{
    $new_quantiry[]=$disp_quantiry[$i]-$count[$i];
    $stmt = $pdo -> prepare("UPDATE shop_list set quantiry=? WHERE id=?");
    $date=array();
    $date[]=$new_quantiry[$i];
    $date[]=$cart[$i];
    $result=$stmt->execute($date);
}
$stmt=null;
//フラグを1にすることで注文処理完了
if($result)
{
    $stmt = $pdo->prepare("UPDATE shop_order set flag=? WHERE mail=? AND flag=0");
    $date=array();
    $date[]=1;
    $date[]=$mail;
    $stmt->execute($date);
    $_SESSION['aitem_by']=1;
    header('location:shop_by.php');
}
?>
