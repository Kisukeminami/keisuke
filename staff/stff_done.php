<?php 
require_once('../dbc/sraff_dbc.php');
severrq();
session();
$post=sanitize($_POST);
$staff_name = $post['name'];
$staff_anthority=$post['anthority'];
$staff_pass = password_hash($post['pass'],PASSWORD_DEFAULT);

?>

<?php 
try {

    
    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        ]);
        
$sql='INSERT INTO shop_staff(name,password,anthority) VALUES (?,?,?)';
$stmt=$dbh->prepare($sql);
$date[]=$staff_name;
$date[]=$staff_pass;
$date[]=$staff_anthority;
$stmt->execute($date);

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
    <title>Document</title>
</head>
<body>
    <div id=wrapper>
    <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
<h2><?php echo $staff_name?>さんを追加しました<br></h2>
<a href="staff_list.php">戻る</a>
</div>
</body>
</html>
