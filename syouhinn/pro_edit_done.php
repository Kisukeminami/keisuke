<?php
require_once('../dbc/sraff_dbc.php');
severrq();
session(); 
if(!isset($_SESSION['id'])):
    exit("直接アクセス禁止");
endif;
session_regenerate_id(true);
 
    $post=sanitize($_POST);
    $pro_name=$post['name'];
    $pro_cood=$post['cood'];
    $pro_cood_old=$post['cood_old'];
    $pro_price=$post['price'];
    $pro_text=$post['text'];
    $pro_quantiry=$post['quantiry'];
    $pro_tax=$post['tax'];
   
    if (empty(!$_POST['file_path'])) {
        $pro_file_path=$_POST['file_path'];
    }else{
        $pro_file_path=$_POST['file_path_old'];
    }
    $pro_file_path_old=$_POST['file_path_old'];
    $pro_size=$_POST['size'];
    if (empty(!$_POST['file_path_right'])) {
        $pro_file_path_right=$_POST['file_path_right'];
    }else{
        $pro_file_path_right=$_POST['file_path_right_old'];
    }
    $pro_file_path_right_old=$_POST['file_path_right_old'];
    if (empty(!$_POST['file_path_left'])) {
        $pro_file_path_left=$_POST['file_path_left'];
    }else{
        $pro_file_path_left=$_POST['file_path_left_old'];
    }
    $pro_file_path_left_old=$_POST['file_path_left_old'];
    if (empty(!$_POST['file_path_back'])) {
        $pro_file_path_back=$_POST['file_path_back'];
    }else{
        $pro_file_path_back=$_POST['file_path_back_old'];
    }
    $pro_file_path_back_old=$_POST['file_path_back_old'];
    
    $pro_maker=$post['maker'];
    $pro_genle=$post['genle'];
    $pro_category=$post['category'];

 
    try {


    
    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        ]);

$sql_list='UPDATE shop_list SET cood=?,name=?,file_path=?,text=?,quantiry=? WHERE cood=?';
$stmt_list=$dbh->prepare($sql_list);
$date1[]=$pro_cood;
$date1[]=$pro_name;
$date1[]=$pro_file_path;
$date1[]=$pro_text;
$date1[]=$pro_quantiry;
$date1[]=$pro_cood_old;
$stmt_list->execute($date1);
 if($pro_file_path_old!=$pro_file_path){
     unlink('image/'.$pro_file_path_old);
 }



$sql_detail='UPDATE list_detail SET cood=?,size=?,file_path_right=?,file_path_left=?,file_path_back=? WHERE cood=?';
$stmt_detail=$dbh->prepare($sql_detail);
$date2[]=$pro_cood;
$date2[]=$pro_size;
$date2[]=$pro_file_path_right;
$date2[]=$pro_file_path_left;
$date2[]=$pro_file_path_back;
$date2[]=$pro_cood_old;
$stmt_detail->execute($date2);

if($pro_file_path_right_old!=$pro_file_path_right){
    unlink('image/'.$pro_file_path_right_old);
}
if($pro_file_path_left_old!=$pro_file_path_left_old){
    unlink('image/'.$pro_file_path_left_old);
}
if($pro_file_path_back_old!=$pro_file_path_back_old){
    unlink('image/'.$pro_file_path_back_old);
}


$sql_sach='UPDATE sach set cood=?,maker=?,genre=?,category=?,price=?,tax=? WHERE cood=?';
$stmt_sach=$dbh->prepare($sql_sach);
$date3[]=$pro_cood;
$date3[]=$pro_maker;
$date3[]=$pro_genle;
$date3[]=$pro_category;
$date3[]=$pro_price;
$date3[]=$pro_tax;
$date3[]=$pro_cood_old;
$stmt_sach->execute($date3);

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
    <title>商品修正</title>
</head>
<body>
    <div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>修正しました</h1>
    <a href="pro_list.php">戻る</a>
<?php unset($_SESSION['imgname']) ?>
<?php unset($_SESSION['imgname_right']) ?>
<?php unset($_SESSION['imgname_left']) ?>
<?php unset($_SESSION['imgname_back']) ?>
</div>
</body>
</html>
