<?php
   
session_start();
	session_regenerate_id(true);
	$_SESSION['id']=date('His');
	if(isset($_SESSION['imgname'])):
		unlink($_SESSION['imgname']);
        unset($_SESSION['imgname']);
	endif;

    header('X-FRAME-OPTIONS: SAMEORIGIN');
    
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form method="post" action="youser_check.php" enctype="multipart/form-data">
    <table>
        <tr>
            <th>ユーザー名:</th><td><input type="text" name="name"> </td>
        </tr>
        <tr>
            <th>性別：</th>
            <td colspan="3"><input type="radio" name="sex" value="0">男
            <input type="radio" name="sex" value="1">女
            <input type="radio" name="sex" value="2">選択しない</td>
        </tr>
        <tr>
            <th>生年月日：</th>
            <td><input type="text" name="basudey"></tr>
        </tr>
        <tr>
            <th>年齢:</th>
            <td colspan="3"><input type="text" id="age" name="age" size="10" required></td>
        </tr>
        <tr>
        <th>郵便番号:</th><td><input type="text" name="post" size="7"></td>
        </tr>
        <tr>
		<th>ＴＥＬ：</th><td><input type="text" name="tel" size="11"></td>
        </tr>
        <tr>
        <th>メールアドレス：</th><td><input type="mail" name="mail" size="50"></td>
        </tr>
        <tr>
        <th>パスワード：</th><td><input type="password" name="pass" size="12"></td>
        </tr>
		<tr>
           <th>アイコン画像：</th><td><input type="file" name="img"></td>
        </tr>
        <tr>
           <th>住所：</th><td><input type="text" name="zyu"></td>
        </tr>
    </table>
    <div id="botan">
    <input type="submit" value="登録">  <input type="reset" value="リセット"> 
    </div>
</form> 

</body>
</html>
