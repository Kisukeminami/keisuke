<?php
   require_once('../dbc/shop_dbc.php');

   var_dump($_POST);
   $post=shop\sanitize($_POST);
var_dump($post);
	if($_SERVER["REQUEST_METHOD"]!=="POST"):
		exit("直接アクセス禁止");
	endif;
	header('X-FRAME-OPTIONS: SAMEORIGIN');
	
	$pdo=shop\dbconect();

	var_dump($pdo);
	$errors=array();
    $name=null;
	$namematch="/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]{1,40}+$/";
	if(!preg_match($namematch,$post["name"])):
		$errors["name"]="ユーザー名を正しく入力してください";
	else:
		$name=$post["name"];
	endif;

    $sex=null;
	if(!isset($post["sex"]) || !strlen($post["sex"])):
		$errors["sex"]="性別を選択してください";
	else:
		$sex=$post["sex"];
	endif;

    $basudey=null;
    $basumatch="/^[0-9]{8}$/";
    if(!preg_match($basumatch,$post["basudey"])):
        $errors["basudey"]="生年月日を正しく入力してください";
    else:
		$basudey=$post["basudey"];
	endif;
    $post1=null;
	$postmatch="/^[0-9]{7}$/";
	if(!preg_match($postmatch,$post["post"])):
		$errors["post"]="郵便番号を正しく入力してください";
	else:
		$post1=$post["post"];
	endif;
var_dump($post);
    $mail=null;
	$mailmatch="/^[a-zA-Z0-9]+[a-zA-Z0-9\._-]*@[a-zA-Z0-9_-]+.[a-zA-Z0-9\._-]+$/";
	if(!preg_match($mailmatch,$post["mail"])):
		$errors["mail"]="メールアドレスを正しく入力してください";
	elseif(strlen($post["mail"])>40):
			$errors["mail"]="メールアドレスが長すぎます";
		else:
			$stmt=$pdo->prepare("SELECT * FROM `youser_sin` WHERE `mail`=:mail");
			$stmt->bindParam(':mail',$post["mail"],PDO::PARAM_STR);
			$stmt->execute();
			$result=$stmt->fetch();
			if($result):
				$errors["mail"]="このメールアドレスは既に登録されています。";
			else:
				$mail=$post["mail"];
			endif;
			$stmt=null;
	endif;
	$zyu=null;
	$zyumatch="/^[都道府県ぁ-んァ-ヶー々一-龠０-９0-9]/";
	if(!preg_match($zyumatch,$post["zyu"])):
		$errors["zyu"]="住所を正しく入力してください";
	else:
		$zyu=$post["zyu"];
	endif;
	
    $tel=null;
	$telmatch="/^0[1-9][0-9]{8,9}$/";
	if(!preg_match($telmatch,$post["tel"])):
		$errors["tel"]="TELを正しく入力してください";
	else:
		$tel=$post["tel"];
	endif;
    $pass=null;
    $telmatch="/^[a-zA-Z0-9]+$/";
	if(!preg_match($telmatch,$post["pass"])):
		$errors["pass"]="パスワードを正しく入力してください";
	else:
		$stmt=$pdo->prepare("SELECT`pass`FROM`youser_sin`");
			$stmt->execute();
    while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($post["pass"], $result['pass'])) {
            $errors["pass"]="このパスワードは既に登録されています";
            break;
        } 
    }
			$stmt=null;
			$pass=password_hash($post['pass'],PASSWORD_DEFAULT);
	endif;

    $e_code=$_FILES["img"]["error"];
	if($e_code!=0):
        $errors['img']="ファイル送信エラー";
	endif;
	$filename="images/".date('YmdHis').$_FILES["img"]["name"];
	if(file_exists($filename)):
		$errors['img']="同名のファイルがアップロードされています";
	endif;
	$filename_save=$filename;
	$res=move_uploaded_file($_FILES["img"]["tmp_name"],$filename_save);
	session_start();
    session_regenerate_id(true);
	$_SESSION['imgname']=$filename_save;
	if(!$res):
		$errors['img']="ファイル保存エラー";
	endif;
	
            
var_dump($name);
    if(count($errors)==0):
		$flag=0;
		$toke_byte = openssl_random_pseudo_bytes(16);
        $toke_token = bin2hex($toke_byte);
		$token = $toke_token;
		//http://localhost:8000
        $url = "/yuser/signup.php?urltoken=".$token;
		$stmt = $pdo -> prepare("INSERT INTO `youser_kai`(`name`,`sex`,`basuday`,`post`,`mail`,`tel`,`pass`,`filename`,`zyu`,`token`,`flag`) 
		VALUES (:name,:sex,:basuday,:post,:mail,:tel,:pass,:filename,:zyu,:token,:flag)");
		$stmt->bindParam(':name',$name);
		$stmt->bindParam(':sex',$sex);
		$stmt->bindParam(':basuday',$basudey);
		$stmt->bindParam(':post',$post1);
		$stmt->bindParam(':mail',$mail);
		$stmt->bindParam(':tel',$tel);
		$stmt->bindParam(':pass',$pass);
		$stmt->bindParam(':filename',$filename_save);
		$stmt->bindParam(':zyu',$zyu);
		$stmt->bindParam(':token',$token);
		$stmt->bindParam(':flag',$flag);
		$stmt->execute();
		$stmt=null;
$pdo=null;

$cood=0;
for ($i=0; $i<6; $i++) {
	$cood.=mt_rand(0,9);
 }
 
$_SESSION['cood']=$cood;
$subject="お問い合わせ";
mb_language('japanese');
mb_internal_encoding('UTF-8');
   $body = <<< EOM
   この度はご登録いただきありがとうございます。
   24時間以内に下記のURLからご登録下さい。
   {$url}
   認証コードです
   {$cood}
EOM;
$from='info@bold-saito-0728.bambina.jp';
$result=mb_send_mail($mail,$subject,$body,$from);

$result=true;
endif;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>登録</title>
</head>
<body>
<?php if (count($errors)): ?>
	<ul class="error_list">
<?php foreach($errors as $error): ?>
		<li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
		</li>
<?php endforeach; ?>
		<li><a href="touroku.html">登録画面に戻る</a></li>
	</ul>
<?php else: ?>
	<?php if($result): ?>
		<p>登録完了しました</p>
		<?php echo $cood;?>
	<p>↓TEST用(後ほど削除)：このURLが記載されたメールが届きます。</p>
   <a href="<?=$url?>"><?=$url?></a>
<?php else: ?>
	<p>送信失敗</p>
<?php endif; ?>

	<p><a href="index.html">ログインページへ</a></p>

<?php endif; ?>
</body>
</html>
