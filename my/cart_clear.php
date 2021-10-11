<?php


session_start();
$_SESSION=array();
if(isset($_CCOKIE[session_name()])==true)
{
    setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>カートを空にしました</h1>
</body>
</html>
