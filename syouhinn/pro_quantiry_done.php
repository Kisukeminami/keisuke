<?php
 require_once('../dbc/sraff_dbc.php');
 //ログインしているか確認
    severrq();
    //POST送信以外のアクセスを防ぐ
    session();
    //引数の値をエスケープする
    $post=sanitize($_POST);
    $pro_name=$post['name'];
    $pro_id=$post['id'];
    $pro_quantiry=$post['quantiry'];
    try {
       
    
        
        $dbh= new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            ]);
    }catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
    //shop_listのquantiryの上書き処理
    $stmt = $dbh -> prepare('UPDATE `shop_list` SET `quantiry` = :quantiry WHERE `id`=:id');
    $stmt -> bindParam(':quantiry',$post['quantiry']);
    $stmt -> bindParam(':id',$post['id']);
    $stmt -> execute();
    $dbh=null;
    ?>
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品個数変更</title>
</head>
<body>
    <div id="wrapper">
<h1>個数を変更しました</h1>
    <a href="pro_list.php">戻る</a>
    </div>
</body>
</html>    

