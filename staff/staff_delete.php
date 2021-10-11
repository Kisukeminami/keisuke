<?php 

require_once('../dbc/sraff_dbc.php');

session();
anthority_top();
$staff_code=$_GET['staff_code'];
try {


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT name FROM shop_staff WHERE staff_code=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$staff_code;
    $stmt->execute($date);
    $staff=$stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name=$staff['name'];
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
    <title>スタッフ削除</title>
</head>
<body>
    <div id="wrapper">
        <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
    <h1>スタッフ削除</h1>
    <h2 id="smele">スタッフコード:<?php echo $staff_code ?></h2>
    <br>
    <h3>このスタッフを削除してもいいですか？</h3>
    <p id="big"><?php echo $staff_name ?>さん</p>
    <form method="post" action="staff_delete_done_check.php">
     <input type="hidden" name="staff_code" value="<?php echo $staff_code?>">
     <input type="button" onclick="history.back()" value="戻る">
     <input type="submit" value="OK">

    </form>
    </div>
</body>
</html>
