<?php 

require_once('../dbc/shop_dbc.php');

session_start();
session_regenerate_id(true);
//クリックジャッキング防止
header('X-FRAME-OPTIONS: SAMEORIGIN');
//接続に必要な情報がdbconect()にはいている。
$pdo=shop\dbconect();
//直接アクセスのURLのtokenがあればsessionに代入
if(isset($_GET["urltoken"])){
    $_SESSION['token']=$_GET["urltoken"];
}
//flag作り
$flag=false;
//空のエラー配列作成
$errors=array();

var_dump(isset($post['cood']));
//$_GETがあるか、$post['cood']があるか、どちらかtrueで処理を始める
if (isset($_GET) || isset($post['cood'])) 
{
    //$_POSTでコードがあれば
    if (isset($_POST['cood'])) 
    {
        //エスケープ
        $post=shop\sanitize($_POST);
        //前ページで生成したランダム値とあっているか判定
        if($_SESSION['cood']===$post['cood']) 
        {
            //あっていたら、urltokenが入っているsessionを$urltokenに代入
            $urltoken=$_SESSION['token'];
                var_dump($urltoken);
                //urltokenの有無
                if (isset($urltoken)) 
                {
                    //ここでフラグを立たせる
                    $flag=true;
                    //youser_kaiにトークンで探しなおかつテーブルに入れた時間から24時間以内
                    $sql = "SELECT*FROM `youser_kai` WHERE `token`=:token AND flag =0 AND time > now() - interval 24 hour";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':token', $urltoken, PDO::PARAM_STR);
                    $stmt->execute();
                    $result=$stmt->fetch();
                    var_dump($result);
                    if ($result) 
                    {
                        $result['name'];
                        $result['sex'];
                        $result['basuday'];
                        $result['post'];
                        $result['mail'];
                        $result['tel'];
                        $result['pass'];
                        $result['filename'];
                        $result['zyu'];
                        $result['flag'];

                        //$resultがtrueならかくDBに入れていく
                        $stmt = $pdo -> prepare("INSERT INTO `youser_aka` (`name`,`pass`,`filename`,`sex`) 
		VALUES (:name,:pass,:filename,:sex)");
                        $stmt->bindParam(':name', $result['name']);
                        $stmt->bindParam(':pass', $result['pass']);
                        $stmt->bindParam(':filename', $result['filename']);
                        $stmt->bindParam(':sex', $result['sex']);
                        $stmt->execute();
        

      
                        $stmt = $pdo -> prepare("INSERT INTO `youser_sin` (`mail`,`pass`,`post`,`tel`,`basuday`,`zyu`) 
		VALUES (:mail,:pass,:post,:tel,:basuday,:zyu)");
                        $stmt->bindParam(':mail', $result['mail']);
                        $stmt->bindParam(':pass', $result['pass']);
                        $stmt->bindParam(':post', $result['post']);
                        $stmt->bindParam(':tel', $result['tel']);
                        $stmt->bindParam(':basuday', $result['basuday']);
                        $stmt->bindParam(':zyu', $result['zyu']);
                        $stmt->execute();
                        $stmt=null;
                    }
                    else
                    {
                        $errors['urltoken'] = "トークンがありません";
                    }
                $stmt = null;
            
                }
             
             }
             else
             {
                 $errors['cood'] ="コードが違います";
             }
    }
    else
    {
        $errors['cood'] ="コードが未入力です";
        
    };
}
else
{
    echo "許可がないです";
    exit();
}
$pdo=null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>登録確認</title>
</head>
<!-- flagがtrueでなおかつ$errors['urltoken'])がないなら　-->
<?php if($flag==true&& !isset($errors['urltoken'])): ?> 
<p>登録完了しました</p>
<a href="../my/login.php">ログインページに</a>
<?php
//sessionを破棄
$_SESSION=array();
if(isset($_CCOKIE[session_name()])==true)
{
    setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>
<!--$_GETか$errors['cood']どっちかがあるなら-->
<?php elseif(isset($_GET) || isset($errors['cood'])):?>
<h2>入力してください</h2>  
<form method="post" action="signup.php" enctype="multipart/form-data">
<input type="text" name="cood">
</form>
<?php if(isset($errors['cood'])):?>
    <?php echo $errors['cood'] ?>
<?php endif;?>
<!-- urltokenがあるなら最初から-->
<?php if (isset($errors['urltoken'])): ?>
<?php echo $errors['urltoken']?>
<a href="yuser\youser.php">もう一度登録してください</a>
<?php endif?>
<?php endif ?>
