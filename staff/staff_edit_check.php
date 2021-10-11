<?php
require_once('../dbc/sraff_dbc.php');
session();
severrq();
try {
    $pdo = new PDO($dsn,$user,$pass,
    array(PDO::ATTR_EMULATE_PREPARES => false));
}
catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}

    $post=sanitize($_POST);
    $staff_code=$post['staff_code'];
    $stff_name=$post['name'];
    $stff_pass=$post['pass'];
    $stff_pass2=$post['pass2'];
    $stff_anthority=$post['anthority'] ?? "役職が選択されていません<br>";

    $errors=array();

if((isset($stff_name) && strlen($stff_name))==false){        
    $errors['name']="スタッフ名が入力されていません";
}elseif(mb_strlen($stff_name)>15){
    $errors['name']="スタッフ名が長いです15文字以内でお願いします";
}

$passmatch="/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{1,11}$/";   
if ((isset($stff_pass) && strlen($stff_pass))==false) {
    $errors['pass']="パスワードが入力されていません";
}elseif(!preg_match($passmatch,$stff_pass)){
    $errors["pass"]="パスワードを正しく入力してください";
}elseif(mb_strlen($stff_pass)>11){
    $errors["pass"]="パスワードは11文字以内にしてください";
}else{
    $stmt=$pdo->prepare("SELECT `password` FROM `shop_staff`");
    $stmt->execute();
    
    while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($stff_pass, $result['password'])) {
            $errors["pass"]="このパスワードは既に登録されています";
            break;
        } else {
            if ($stff_pass!=$stff_pass2) {
                $errors['pass']="パスワードが一致しません";
                break;
            }
        }
    }
}
if ($stff_anthority === "")
     {
        $errors['anthority']=$stff_anthority;
    }elseif($stff_anthority === "1"){
        $anthority="部長";
    }elseif($stff_anthority === "2"){
        
        $anthority="課長";
    }elseif($stff_anthority === "3"){
        $anthority="社員";

    }else{
        $anthority="非正規";


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
    <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
<?php 
    if(count($errors)):
		foreach($errors as $value):?>

	<p><?php echo $value; ?></p>
<?php
		endforeach;
   ?>        
    <input type="button" onclick="history.back()" value="戻る">
    <?php else:?>
    <h2>スタッフ名:<?php echo $stff_name ?></h2>
    <h2>役職:<?php echo $anthority ?></h2>
    <p>こちらに修正しますか？</p> 
    <form method="post" action="stff_edit_done.php">
    <input type="hidden"name="code" value="<?php echo $staff_code?>">   
    <input type="hidden"name="name" value="<?php echo $stff_name?>">
    <input type="hidden"name="pass" value="<?php echo $stff_pass ?>">
    <input type="hidden"name="anthority" value="<?php echo $stff_anthority ?>">
    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
    <?php endif ?>
    </div>
</body>
