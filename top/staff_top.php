<?php 
require_once('../dbc/sraff_dbc.php');
session();
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
    <div id="wrapper">
    <p id=sess>
    <?php echo $_SESSION["staff_name"]."さんログイン中です"?>
</p>
    <h1>管理トップメニュー</h1>
    <div id=menu>
    <a href="../staff/staff_list.php">スタッフ管理</a>
    <a href="../syouhinn/pro_list.php">商品管理</a>
    <a href="../login/staff_logout.php">ログアウト</a>
    </div>
    </div>
</body>
</html>
