<?php 
header('X-FRAME-OPTIONS: SAMEORIGIN');
require_once('../dbc/sraff_dbc.php');
try {
  

    
    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        ]);
}catch (PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }


    $staff_code=$_POST['code'];
    $staff_pass=$_POST['pass'];

    $staff_code=htmlspecialchars($staff_code,ENT_QUOTES,'UTF-8');
    $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

    $errors=array();
    $coodmatch="/^[0-9０-９]{1,4}$/";
    if((isset($staff_code) && strlen($staff_code))==false):      
        $errors['cood']="社員コードが入力されていません";
        $staff_code=null;
    
    elseif(!preg_match($coodmatch,$staff_code)):
		$errors["cood"]="社員コードを正しく入力してください";
        $staff_code=null;
	endif;

    $passmatch="/^[a-zA-Z0-9]+$/";
    if((isset($staff_pass) && strlen($staff_pass))==false):      
        $errors['pass']="パスワードが入力されていません";
        $staff_pass=null;
    
    elseif(!preg_match($passmatch,$staff_pass)):
		$errors["pass"]="パスワードを正しく入力してください";
        $staff_pass=null;

	endif;
   ?>
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
    <?php
    if(count($errors)):
            foreach($errors as $value):?>
    
        <p><?php echo $value; ?></p>
    <?php
            endforeach;
     ?>
            <input type="button" onclick="history.back()" value="戻る">
    <?php
        else:
$sql='SELECT *FROM shop_staff WHERE staff_code=?';
$stmt=$dbh->prepare($sql);
$date[]=$staff_code;
$stmt->execute($date);

$dbh = null;

$staff=$stmt->fetch(PDO::FETCH_ASSOC);
var_dump($staff['password']);
var_dump($staff_pass);
if($staff==false):
?>
    <h2>スタッフコードが間違っています</h2>
    <h3><a href="staff_login.php">戻る</a></h3>

    
<?php
exit();
elseif(password_verify($staff_pass,$staff['password'])==false):
?>
    <h2>パスワードが間違っています</h2>
    <h3><a href="staff_login.php">戻る</h3>
<?php
   exit();
endif;

{
    session_start();
    $_SESSION['login']=1;
    $_SESSION['staff_code']=$staff_code;
    $_SESSION['staff_name']=$staff['name'];
    $_SESSION['staff_anthority']=$staff['anthority'];
    header('location:../top/staff_top.php');
    exit();
}
?>
    </form>
    <?php  endif?>
    </div>
</body>
</html>
