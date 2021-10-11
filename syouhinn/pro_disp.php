<?php
require_once('../dbc/sraff_dbc.php');

session();
anthority_sarede();
$pro_code=$_GET['pro_code'];
try {
  


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$pro_code;
    $stmt->execute($date);
    $all_aitems=$stmt->fetchAll(PDO::FETCH_ASSOC);

    
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
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品情報</title>
</head>
<body>
    <div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>商品情報</h1>
    <br>
    <?php foreach($all_aitems as $all_aitem):?>
    <h3>商品コード<?php echo $all_aitem['cood'] ?></h3>
    <h3>商品記載時間<?php echo $all_aitem['insert_time'] ?></h3>
   <h3>商品名<?php echo $all_aitem['name'] ?></h3>
   <h3>商品価格<?php echo $all_aitem['price'] ?></h3>
   <h3>商品説明<?php echo $all_aitem['text'] ?></h3>
   <h3>商品サイズ<?php echo $all_aitem['size'] ?></h3>
   <h3>商品個数<?php echo $all_aitem['quantiry'] ?></h3>
   <h3>消費税<?php echo $all_aitem['tax'] ?></h3>
   <h3>メーカー<?php echo $all_aitem['maker'] ?></h3>
   <h3>ジャンル<?php echo $all_aitem['genre'] ?></h3>
   <h3>カテゴリー</h3><?php 
    if( $all_aitem["category"] === "1"):?>
        <h4>テーブル<h4>
    <br>
    <?php elseif($all_aitem["category"] === "2"): ?>
        <h4> イス</h4>
        <br>
    <?php elseif($all_aitem["category"] === "3"): ?>
     <h4>ソファー</h4>
     <br>
    <?php else :?>
    <h4>その他</h4>
    <br>
     <?php endif ?>
     <h3>メイン商品画像</h3>
     <img src="image/<?php echo $all_aitem['file_path']?>">
     <br>
     <h3>商品右画像</h3>
     <img src="image/<?php echo $all_aitem['file_path_right']?>">
     <br>
     <h3>商品左画像</h3>
     <img src="image/<?php echo $all_aitem['file_path_left']?>">
     <br>
     <h3>商品後ろ画像</h3>
    <img src="image/<?php echo $all_aitem['file_path_back']?>">
     <br>
 <?php endforeach ?>       
     <input type="button" onclick="history.back()" value="戻る">

    </form>
    </div>
</body>
</html>
