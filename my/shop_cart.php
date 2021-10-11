<?php 
header('X-FRAME-OPTIONS: SAMEORIGIN');
session_start();
session_regenerate_id(true);
if(isset($_SESSION['menber_login'])==false)
{
 function yuser(){
     echo "ゲストユーザー";
     echo '<a href="menber_login.html">会員ログイン</a>';
 }
}else{
    function yuser()
    {
        echo "ようこそ".$_SESSION['menber_name']."様";
        echo '<a href="menber_logout.html">会員ログイン</a>';
    }
}
yuser();
var_dump($_GET['proid']);
$pro_id=$_GET['proid'];
var_dump($_SESSION['cart']);
echo "<br>";
var_dump($_SESSION['count']);
try {
    if (isset($_SESSION['cart'])==true) {
        $cart=$_SESSION['cart'];
        $count=$_SESSION['count'];
    }
        $cart[]=$pro_id;
        $count[]=1;
        $_SESSION['cart']=$cart;
        $_SESSION['count']=$count;
    //var_dump($count[]);

    } catch (PDOException $e) {
    echo "接続失敗".$e->getMessage();
    exit();

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報</title>
</head>
<body>
    <h1>商品情報</h1>
    <br>
    <?php foreach($cart as $key=>$val):?>
   <?php echo $val; ?><br>

 <?php endforeach ?>       
   <h3>カートに追加しました</h3>
 <a href="list.php">商品一覧ページへ</a>
</body>
</html>
