<?php
require_once('../dbc/sraff_dbc.php');
//POST送信以外のアクセスを防ぐ
severrq();
//ログインしているか確認
session();

	
try {
//引数の値をエスケープする
    $post=sanitize($_POST);
    $pro_name=$post['name'];
    $pro_cood=$post['cood'];
    $pro_price=$post['price'];
    $pro_text=$post['text'];
    $pro_file_path=$post['file_path'];
    $pro_quantiry=$post['quantiry'];
    $pro_tax=$post['tax'];
    $pro_size=$post['size'];
    $pro_file_path_right=$post['file_path_right'];
    $pro_file_path_left=$post['file_path_left'];
    $pro_file_path_back=$post['file_path_back'];
    $pro_maker=$post['maker'];
    $pro_genle=$post['genle'];
    $pro_category=$post['category'];

    

    
    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        ]);
//shop_listのテーブルに保存
$sql_list='INSERT INTO shop_list(cood,name,file_path,text,quantiry) VaLUES (?,?,?,?,?)';
$stmt_list=$dbh->prepare($sql_list);
$date1[]=$pro_cood;
$date1[]=$pro_name;
$date1[]=$pro_file_path;
$date1[]=$pro_text;
$date1[]=$pro_quantiry;
$stmt_list->execute($date1);



//list_detailのテーブルに保存
$sql_detail='INSERT INTO list_detail(cood,size,file_path_right,file_path_left,file_path_back) VaLUES (?,?,?,?,?)';
$stmt_detail=$dbh->prepare($sql_detail);
$date2[]=$pro_cood;
$date2[]=$pro_size;
$date2[]=$pro_file_path_right;
$date2[]=$pro_file_path_left;
$date2[]=$pro_file_path_back;
$stmt_detail->execute($date2);


//sachのテーブルに保存
$sql_sach='INSERT INTO sach(cood,maker,genre,category,price,tax) VaLUES (?,?,?,?,?,?)';
$stmt_sach=$dbh->prepare($sql_sach);
$date3[]=$pro_cood;
$date3[]=$pro_maker;
$date3[]=$pro_genle;
$date3[]=$pro_category;
$date3[]=$pro_price;
$date3[]=$pro_tax;
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
    <title>商品追加</title>
</head>
<body>
    <div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h2>追加しました</h2>
<a href="pro_list.php">戻る</a>
<!--　各$_SESSIONの中身を消す -->
<?php unset($_SESSION['imgname']) ?>
<?php unset($_SESSION['imgname_right']) ?>
<?php unset($_SESSION['imgname_left']) ?>
<?php unset($_SESSION['imgname_back']) ?>
</div>
</body>
</html>
