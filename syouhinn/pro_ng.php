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
    <title>商品未選択</title>
</head>
<body>
    <div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>商品が選択されていません</h1><br>
    <a href="pro_list.php">戻る</a>
    </div>
</body>
</html>
