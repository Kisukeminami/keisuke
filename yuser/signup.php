<?php 
require_once('../dbc/shop_dbc.php');

session_start();
session_regenerate_id(true);
header('X-FRAME-OPTIONS: SAMEORIGIN');
$pdo=shop\dbconect();
if(isset($_GET["urltoken"])){
    $_SESSION['token']=$_GET["urltoken"];
}
$flag=false;
$errors = array();

var_dump(isset($post['cood']));
if (isset($_GET) || isset($post['cood'])) {
    
    if (isset($_POST['cood'])) {
        $post=shop\sanitize($_POST);
        if($_SESSION['cood']===$post['cood']) {
            $urltoken=$_SESSION['token'];
                var_dump($urltoken);
                if (isset($urltoken)) {
                    $flag=true;
                    $sql = "SELECT*FROM `youser_kai` WHERE `token`=:token AND flag =0 AND time > now() - interval 24 hour";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':token', $urltoken, PDO::PARAM_STR);
                    $stmt->execute();
                    $result=$stmt->fetch();
                    var_dump($result);
                    if ($result) {
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
                    };/*else{
                $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
                $stmt = null;
            }*/
                }else{
                    $errors['urltoken'] = "トークンがありません";
                }
             
             }else{
                 $errors['cood'] ="コードが違います";
             }
    }else{
        $errors['cood'] ="コードが未入力です";
        
    };
}else{
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
<?php if($flag==true): ?> 
<p>登録完了しました</p>
<a href="../my/login.php">ログインページに</a>
<?php

$_SESSION=array();
if(isset($_CCOKIE[session_name()])==true)
{
    setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>
<?php elseif(isset($_GET) || isset($errors['cood'])):?>
<h2>入力してください</h2>  
<form method="post" action="signup.php" enctype="multipart/form-data">
<input type="text" name="cood">
</form>
<?php if(isset($errors['cood'])):?>
    <?php echo $errors['cood'] ?>
<?php endif;?>
<?php if (isset($errors['urltoken'])): ?>
<?php echo $errors['urltoken']?>
<a href="yuser\youser.php">もう一度登録してください</a>
<?php endif?>
<?php endif ?>
