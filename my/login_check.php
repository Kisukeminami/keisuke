<?php
require_once('../dbc/sraff_dbc.php');
$post=sanitize($_POST);

 if($_SERVER["REQUEST_METHOD"]!=="POST"):
     exit("直接アクセス禁止");
 endif;
 header('X-FRAME-OPTIONS: SAMEORIGIN');

 $flag=false;
 try{
    

    $pdo = new PDO($dsn,$user,$pass,
		array(PDO::ATTR_EMULATE_PREPARES => false));
 }catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}
$post=sanitize($_POST);
$errors=array();

$namematch="/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]{1,40}+$/";
$name=null;
if(!preg_match($namematch,$post['name'])){
    $errors["name"]="ユーザー名を正しく入力してください";
}else{
    $name=$post["name"];

}

$passmatch="/^[a-zA-Z0-9]+$/";
$pass=null;
if(!preg_match($passmatch,$post['pass'])){
    $errors["pass"]="ユーザー名を正しく入力してください";
}else{
$stmt=$pdo->prepare("SELECT `pass` FROM `youser_aka` ");
$stmt->execute();
while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
    if(password_verify($post["pass"],$result['pass'])){
        $stmt=$pdo->prepare("SELECT * FROM `youser_aka` WHERE `name`=:name ");
        $stmt->bindParam(':name',$post["name"],PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetch();
        if($result){
            $flag=true;
            session_start();
            session_regenerate_id(true);
            $_SESSION['name']=$result['name'];
            $_SESSION[`filename`]=$result['filename'];
            $_SESSION['pass']=$result['pass'];
        }else{
            $errors["name"]="このユーザー名は存在していません";
        }
        break;
    }
}
$errors["pass"]="このパスワードは間違っています";
    
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインチェック</title>
</head>
<body>
    <?php if(count($errors)): ?>
        <ul class="error_list">
<?php foreach($errors as $error): ?>
		<li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
		</li>
<?php endforeach; ?>
<li><a href="login.php">ログイン画面に戻る</a></li>
<?php endif; ?>
<?php if($flag===true){
header('location:../my/list.php');
}
?>
</body>
</html>
