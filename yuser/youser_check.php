<?php
   require_once('../dbc/shop_dbc.php');

   var_dump($_POST);
   //エスケープ
   $post=shop\sanitize($_POST);
var_dump($post);
	if($_SERVER["REQUEST_METHOD"]!=="POST"):
		exit("直接アクセス禁止");
	endif;
	//クリックジャッキング防止
	header('X-FRAME-OPTIONS: SAMEORIGIN');
	
	$pdo=shop\dbconect();

	var_dump($pdo);
	//空の配列作成
	$errors=array();
    $name=null;
	
	$namematch="/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9]{1,40}+$/";
	//正規表現で$post["name"]の中身チェック
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
	//正規表現で$post["basudey"]の中身確認
    $basumatch="/^[0-9]{8}$/";
    if(!preg_match($basumatch,$post["basudey"])):
        $errors["basudey"]="生年月日を正しく入力してください";
    else:
		$basudey=$post["basudey"];
	endif;
    $post1=null;
	//正規表現　で$post["post"]の中身確認
	$postmatch="/^[0-9]{7}$/";
	if(!preg_match($postmatch,$post["post"])):
		$errors["post"]="郵便番号を正しく入力してください";
	else:
		$post1=$post["post"];
	endif;
var_dump($post);
    $mail=null;
	//正規表現で$post["mail"]の中身確認し大丈夫なら登録されていないか確認
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
	//正規表現で$post["zyu"]の中身確認
	$zyumatch="/^[都道府県ぁ-んァ-ヶー々一-龠０-９0-9]/";
	if(!preg_match($zyumatch,$post["zyu"])):
		$errors["zyu"]="住所を正しく入力してください";
	else:
		$zyu=$post["zyu"];
	endif;
	//正規表現で$post["tel"]の中身確認
    $tel=null;
	$telmatch="/^0[1-9][0-9]{8,9}$/";
	if(!preg_match($telmatch,$post["tel"])):
		$errors["tel"]="TELを正しく入力してください";
	else:
		$tel=$post["tel"];
	endif;
	//正規表現で$post["pass"]の中身確認、大丈夫ならパスワードの重複確認
    $pass=null;
    $telmatch="/^[a-zA-Z0-9]+$/";
	if(!preg_match($telmatch,$post["pass"])):
		$errors["pass"]="パスワードを正しく入力してください";
	else:
		$stmt=$pdo->prepare("SELECT`pass`FROM`youser_sin`");
			$stmt->execute();
    while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) {
		//passカラムの値と$post["pass"]を同じか見る
        if (password_verify($post["pass"], $result['pass'])) {
            $errors["pass"]="このパスワードは既に登録されています";
            break;
        } 
    }
			$stmt=null;
			//$post['pass']がないなら$post['pass']をハッシュ化
			$pass=password_hash($post['pass'],PASSWORD_DEFAULT);
	endif;
//ファイル確認、保存
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
	
//エラーがなければトークン生成仮のデータベースに登録
var_dump($name);
    if(count($errors)==0):
		$flag=0;
		$toke_byte = openssl_random_pseudo_bytes(16);
        $toke_token = bin2hex($toke_byte);
		$token = $toke_token;
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
//確認コードの生成
$cood=0;
//確認コードを６桁にする
for ($i=0; $i<6; $i++) {
	$cood.=mt_rand(0,9);
 }
 //sessionに代入
$_SESSION['cood']=$cood;

//登録したアドレスにメール送信
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


endif;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>登録</title>
</head>
<body>
<!-- エラーがあればメッセージを表示-->
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

	<!-- 送信完了したなら$resultがtrue　-->
	<?php if($result): ?>
		<p>登録完了しました</p>
		<?php echo $cood;?>
	<p>↓TEST用：このURLが記載されたメールが届きます</p>
   <a href="<?=$url?>"><?=$url?></a>
<?php else: ?>
	<p>送信失敗</p>
<?php endif; ?>

	<p><a href="index.html">ログインページへ</a></p>

<?php endif; ?>
</body>
</html>

    
