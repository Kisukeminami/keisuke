<?php
header('X-FRAME-OPTIONS: SAMEORIGIN');

?><!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーログイン</title>
</head>
<body>
    <form method="post" action="login_check.php">
        パスワード：<input type="text" name="pass">
        名前：<input type="text" name="name">
        <input type="submit" value="ログイン">
    </form> 
</body>
</html>
