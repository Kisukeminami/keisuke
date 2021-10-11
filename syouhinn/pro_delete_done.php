<?php 

require_once('../dbc/sraff_dbc.php');

session();
$pro_code = $_POST['code'];
$pro_file_path=$_POST['file_path'];
$pro_file_path_right=$_POST['file_path_right'];
$pro_file_path_left=$_POST['file_path_left'];
$pro_file_path_back=$_POST['file_path_back'];

try {

    
        
        $dbh= new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            ]);
    $sql='DELETE shop_list,list_detail,sach  FROM  shop_list INNER JOIN list_detail ON shop_list.cood = list_detail.cood INNER JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$pro_code;
    $stmt->execute($date);
           
    
    if($pro_file_path!=""){
        unlink('image/'.$pro_file_path);
    }
    if($pro_file_path_right!=""){
        unlink('image/'.$pro_file_path_right);
    }

    if($pro_file_path_left!=""){
        unlink('image/'.$pro_file_path_left);
    }

    if($pro_file_path_back!=""){
        unlink('image/'.$pro_file_path_back);
    }

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
    <title>商品削除、</title>
</head>
<body>
    <div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h2>削除しました</h2>
<a href="pro_list.php">戻る</a>
</div>
</body>
</html>
