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

var_dump($_GET['proid']);
$pro_code=$_GET['proid'];

try {



    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$pro_code;
    $stmt->execute($date);
    $disp_aitems=$stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $dbh=null;


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
    <?php foreach($disp_aitems as $disp_aitem): ?> 
   <h3>商品名</h3><?php echo $disp_aitem['name'] ?>
   <h3>商品価格</h3><?php echo $disp_aitem['price'] ?>
   <h3>商品説明</h3><?php echo $disp_aitem['text'] ?>
   <h3>商品サイズ</h3><?php echo $disp_aitem['size'] ?>
   <h3>メーカー</h3><?php echo $disp_aitem['maker'] ?>
   <h3>ジャンル</h3><?php echo $disp_aitem['genre'] ?>
   <h3>カテゴリー</h3><?php 
    if( $disp_aitem["category"] === "1"):?>
        <h4>テーブル<h4>
    <br>
    <?php elseif($disp_aitem["category"] === "2"): ?>
        <h4> イス</h4>
        <br>

    <?php elseif($disp_aitem["category"] === "3"): ?>
     <h4>ソファー</h4>
     <br>

    <?php else :?>
        <h4>その他</h4>
        <br>
     <?php endif ?>
     <h3>メイン商品画像</h3>
     <?php echo '<img src="../syouhinn/image/'.$disp_aitem['file_path'].'">' ?>
     <br>
     <h3>商品右画像</h3>
     <?php echo '<img src="../syouhinn/image/'.$disp_aitem['file_path_right'].'">' ?>
     <br>
     <h3>商品左画像</h3>
     <?php echo '<img src="../syouhinn/image/'.$disp_aitem['file_path_left'].'">' ?>
     <br>
     <h3>商品後ろ画像</h3>
     <?php echo '<img src="../syouhinn/image/'.$disp_aitem['file_path_back'].'">' ?>
     <br>
     <a href="shop_cart.php?proid=<?php echo $disp_aitem['id']?>">カートに入れる</a>
<?php var_dump($disp_aitem['id'])?>
<?php endforeach ?>
