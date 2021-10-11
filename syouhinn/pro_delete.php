<?php 
var_dump($_POST);
require_once('../dbc/sraff_dbc.php');

session();
anthority_sarede();
$pro_code=$_GET['pro_code'];
try {



    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood  WHERE id=?';
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
    <title>商品削除</title>
</head>
<body>
<div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>商品削除</h1>
    <?php foreach($all_aitems as $all_aitem):?>
    <h2>商品コード: <?php echo $all_aitem['cood'] ?></h2>
    <br>
    <h3>この商品を削除してもいいですか？</h3>
    <p><?php echo $all_aitem['name'] ?></p>
    <img src="image/<?php echo $all_aitem['file_path']?>">
    
    <form method="post" action="pro_delete_done.php">
    <input type="hidden" name="code" value="<?php echo $all_aitem['id'] ?>">
    <input type="hidden" name="file_path" value="<?php echo $all_aitem['file_path'] ?>">
    <input type="hidden" name="file_path_right" value="<?php echo $all_aitem['file_path_right'] ?>">
    <input type="hidden" name="file_path_left" value="<?php echo $all_aitem['file_path_left'] ?>">
    <input type="hidden" name="file_path_back" value="<?php echo $all_aitem['file_path_back'] ?>">
    <?php endforeach ?> 
     <input type="button" onclick="history.back()" value="戻る">
     <input type="submit" value="OK">

    </form>
    </div>
</body>
</html>
