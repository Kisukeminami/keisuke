<?php 

require_once('../dbc/sraff_dbc.php');
//ログインしているか確認
session();
//POST送信以外のアクセスを防ぐ
severrq();
try 
{
    $pdo = new PDO($dsn,$user,$pass,
    array(PDO::ATTR_EMULATE_PREPARES => false));
}
catch (PDOException $e) 
{
    exit('データベース接続失敗。'.$e->getMessage());
}
//$_POSTをエスケープ
$post=sanitize($_POST);
/*$stff_nameをフィルタリングする処理,訓練校では習っていなかった
試しに使ってみた、フィルタを指定しないとあまり意味がなさそう
現場ではどうだろうか、、、、*/
$stff_name=filter_input(INPUT_POST,'name',);
//??は値がなければ"役職が選択されていません<br>"が代入
$staff_anthority=$post['anthority'] ?? "役職が選択されていません<br>";
$stff_pass=$post['pass'];
$stff_pass2=$post['pass2'];
//エラーの空の配列作成
$errors=array();
//$stff_nameの有無
if((isset($stff_name) && strlen($stff_name))==false)
{        
    $errors['name']="スタッフ名が入力されていません";
    //長さ確認
}elseif(mb_strlen($stff_name)>15)
{
    $errors['name']="スタッフ名が長いです15文字以内でお願いします";
}
//チェックされた、ものに役職を代入
if($staff_anthority == "1")
{
    $new_anthority="部長";
}elseif($staff_anthority== "2")
{
    $new_anthority="課長";

}
elseif($staff_anthority == "3")
{
 $new_anthority="社員";

}
elseif($staff_anthority == "4")
{
        $new_anthority="非正規";
}
else
{
    //なければ、エラーメッセージが代入されているのでそのまま代入
    $errors['anthority']=$staff_anthority;
}
//正規表現a-z、A-Z、0-9を一つ以上　一文字以上11文字以下
$passmatch="/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{1,11}$/";   
if ((isset($stff_pass) && strlen($stff_pass))==false) 
{
    $errors['pass']="パスワードが入力されていません";
}elseif(!preg_match($passmatch,$stff_pass))
{
    $errors["pass"]="パスワードを正しく入力してください";
}elseif(mb_strlen($stff_pass)>11)
{
    $errors["pass"]="パスワードは11文字以内にしてください";
}
else
{
    //パスワードが使われていないかみる
    $stmt=$pdo->prepare("SELECT `password` FROM `shop_staff`");
    $stmt->execute();
    //取得したパスワードを調べる
    while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) 
    {
        //password_verifyで解読、trueならエラー
        if (password_verify($stff_pass, $result['password'])) 
        {
            $errors["pass"]="このパスワードは既に登録されています";
            break;
            //大丈夫なら二つコードを照らし合わせる
        } 
        else 
        {
            if ($stff_pass!=$stff_pass2)
             {
                $errors['pass']="パスワードが一致しません";
                break;
            }
        }
    }
}
?>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>スタッフぺージ</title>
</head>
<body>
    <div id="wrapper">
        <p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
<?php
//$errors配列が入っていれば実行
if(count($errors)):
		foreach($errors as $value):?>

	<p><?php echo $value; ?></p>
<?php
		endforeach;
   ?>     

        <input type="button" onclick="history.back()" value="戻る">
     
     <?php else: ?>
    <h2>スタッフ名<?php echo $stff_name ?>になります。</h2>
    <h3>役職は<?php echo $new_anthority ?>になります。</h3>
    <p>こちらのスタッフを追加します</p>
    <form method="post" action="stff_done.php">
    <input type="hidden"name="name" value="<?php echo $stff_name?>">
    <input type="hidden"name="pass" value="<?php echo $stff_pass ?>">
    <input type="hidden"name="anthority" value="<?php echo $staff_anthority ?>">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
    <?php  endif?>
    </div>
</body>
</html>
