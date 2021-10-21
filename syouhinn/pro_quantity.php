<?php
require_once('../dbc/sraff_dbc.php');

session();
session_regenerate_id(true);
$_SESSION['id']=date('His');
$pro_code=$_GET['pro_code'];
try {

    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);
//shop_list,list_detail,sachを結合しidで紐ずけ
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
    <title>商品個数修正</title>
</head>
<body>
<div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
<?php foreach($all_aitems as $all_aitem):?>
    <form method="post" action="pro_quantity_check.php" >
    
     <h3>商品メイン画像</h3>
    <img src="image/<?php echo $all_aitem['file_path']?>">
    <br>
    <h3>商品名</h3>
    <?php echo $all_aitem['name'] ?>
    <h3>コード</h3>
    <?php echo $all_aitem['cood'] ?>
    <h3>商品価格</h3>
    <?php echo $all_aitem['price'] ?>
    <h3>商品説明</h3>
    <?php echo $all_aitem["text"] ?>
    <h3>商品個数</h3>
    <input type="number" name="quantiry" style="width: 200px" value="<?php echo $all_aitem['quantiry'] ?>">
    <br>
<?php endforeach ?>
<input type="hidden" name="name" value="<?php echo $all_aitem['name']?>">
<input type="hidden" name="id" value="<?php echo $all_aitem['id']?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>
</div>
</body>
</html>      
