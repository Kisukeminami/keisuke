<?php 

require_once('../dbc/sraff_dbc.php');
session();

$post=sanitize($_POST);
$staff_code = $post['code'];
$staff_name = $post['name'];
$staff_pass = password_hash($post['pass'],PASSWORD_DEFAULT);
$staff_anthority = $post['anthority'];
try {
        
        $dbh= new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            ]);
    
    $sql='UPDATE shop_staff SET name=?,password=?,anthority=? WHERE staff_code=? ';
    $stmt=$dbh->prepare($sql);
    $date[]=$staff_name;
    $date[]=$staff_pass;
    $date[]=$staff_anthority;
    $date[]=$staff_code;
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
    <title>修正</title>
</head>
<body>
    <div id="wrapper">
        <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
    <h2>修正しました</h2>
<a href="staff_list.php">戻る</a>
</div>
</body>
</html>
