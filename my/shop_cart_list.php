<?php 
header('X-FRAME-OPTIONS: SAMEORIGIN');
require_once('../dbc/sraff_dbc.php');
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
if(isset($_SESSION['cart'])==false){
    
exit("商品がカートに入っていません");
}
$cart=$_SESSION['cart'];
$count=$_SESSION['count'];
var_dump($count);
$max=count($cart);
try {
    


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    foreach ($cart as $key=>$value) {
        $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $date[0]=$value;
        $stmt->execute($date);
        $disp_aitems=$stmt->fetch(PDO::FETCH_ASSOC);

        //qrint_r(array_column($disp_aitems,'name'));

    $disp_name[]=$disp_aitems['name']; 
    $disp_price[]=$disp_aitems['price']; 
    $disp_size[]=$disp_aitems['size']; 
    if( $disp_aitems["category"] === "1"):
        $disp_ctegory[]="テーブル";
     elseif($disp_aitems["category"] === "2"):
        $disp_ctegory[]="イス";

    elseif($disp_aitems["category"] === "3"): 
        $disp_ctegory[]="ソファー";

     else :
        $disp_ctegory[]="その他";

      endif ;
     $disp_image[]=$disp_aitems['file_path'];
     $disp_quantiry[]=$disp_aitems['quantiry'];
    }
    


    } catch (PDOException $e) {
    echo "接続失敗".$e->getMessage();
    exit();

}
$tatalprice=0;
$dbh=null;?>

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
 <form method="post" action="count.php">
<?php for($i=0;$i<$max;$i++):?>
    <h3><?php echo $disp_name[$i] ?> </h3>
    <h3><?php echo $disp_price[$i] ?></h3>
    <h3><?php echo $disp_size[$i] ?></h3>
    <img src="../syouhinn/image/<?php echo $disp_image[$i]?>" width="200px" height="200px">
    <input type="number" name="count<?php echo $i;?>" value="<?php echo $count[$i];?>"max="<?php echo $disp_quantiry[$i]?>">
    <input type="checkbox" name="delete<?php echo $i ?>"> 
    <?php 
    $price=$disp_price[$i]*$count[$i] ;
    $tatalprice+=$price ;?>
    <?php endfor?>
    <br>
    <h3>カート合計金額：<?php echo $tatalprice ?></h3>

<br>
<input type="hidden" name="max" value="<?php echo $max ;?>">
<input type="submit" value="数量変更">

</form>
<a href="list.php">戻る</a>
