<?php header('X-FRAME-OPTIONS: SAMEORIGIN');?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>ログイン</title>
</head>
<body>
    <div id="wrapper">
    <h1>スタッフログイン</h1>
    <form method="post" action="staff_login_check.php">
    <h2>スタッフコード</h2>
    <input type="text" name="code">
    <h2>パスワード</h2>
    <input type="password" name="pass">
    <input type="submit" value="ログイン">
    </form>
    </div>
</body>
</html>
