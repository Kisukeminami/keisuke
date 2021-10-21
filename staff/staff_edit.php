<?php 

$staff_code=$_GET['staff_code'];
require_once('../dbc/sraff_dbc.php');
//ログインしているか確認
session();
//スタッフの権限確認、2番強い権限、以下なら別ページに飛ばす
 anthority_second();

try 
{
  


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);
//staff_codeで紐付けてDBから取得
    $sql ='SELECT *FROM shop_staff WHERE staff_code=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$staff_code;
    $stmt->execute($date);
    $staff=$stmt->fetch(PDO::FETCH_ASSOC);

    $dbh=null;


    } 
    catch (PDOException $e) 
    {
    echo "接続失敗".$e->getMessage();
    exit();

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>スタッフ詳細</title>
</head>
<body>
    <div id="wrapper">
    <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
    <h1>詳細スタッフ</h1>
    <h2>スタッフコード：<?php echo $staff_code ?></h2>
    <form method="post" action="staff_edit_check.php">
     <input type="hidden"  name="staff_code" value="<?php echo $staff_code?>">
     <h3>スタッフ名</h3>
     <input type="text"  id=name name="name" style="width: 200px" value="<?php echo $staff['name'] ?>">
     <p class="warning" id="warning"></p>  
     <br>
     <h3>役職</h3>
     <!--空の$checkを用意し、所得したanthorityの値によってcheckedを入れる -->
     <?php $check1="" ?>
     <?php $check2="" ?>
     <?php $check3="" ?>
     <?php $check4="" ?>
    <?php switch($staff['anthority'])
    {
        case "1":
        $check1="checked";
            break;
        case "2";
        $check2="checked";
            break;
        case "3";
        $check3="checked";
            break;
        case "4";
        $check4="checked";
            break;        
    }
    ?>
      <input type="radio" name="anthority" <?php echo $check1 ?> value="1">部長
    　<input type="radio" name="anthority" <?php echo $check2 ?> value="2">課長
    　<input type="radio" name="anthority" <?php echo $check3 ?> value="3">社員
    　<input type="radio" name="anthority" <?php echo $check4 ?> value="4">非正規
    <p class="warning" id="warning0"></p>  
     <br>  
     <h3>新しいパスワードを入力してください</h3>
     <input type="password" id=pass name="pass" style="width: 200px">
     <p>半角英数、全角英、それぞれ一つずつ入れてください</p>
     <p class="warning" id="warning1"></p>
     <br>
     <h3>パスワードをもう一度入力してください</h3>
     <input type="password" id=pass2 name="pass2" style="width: 200px">
     <p class="warning" id="warning2"></p>
     <br>
     <input type="button" onclick="history.back()" value="戻る">
     <input type="submit" id=btn value="OK">

    </form>
    </div>
    <script>
        //idの所得、
            const name=document.getElementById('name');
            const btn=document.getElementById('btn');
            const pass=document.getElementById('pass');
            const pass2=document.getElementById('pass2');
            const warning=document.getElementById('warning');
            const warning1=document.getElementById('warning1');
            const warning2=document.getElementById('warning2');
            //ボタン命令　各idの空か長くないか、押されたら発火
            btn.onclick=function()
            {
                if(name.value.length=="")
                {
                    warning.innerHTML="スタッフ名が入力されていません";
                    return false;
                }
                if(15<=name.value.length)
                {
                    warning.innerHTML="スタッフ名が長すぎます。15文字以内に下ください";
                    return false;
                }
                if(pass.value.length=="")
                {
                    warning1.innerHTML="パスワードが入力されてないです。";
                    return false;
                }
                if(32<=pass.value.length)
                {
                    warning1.innerHTML="パスワードが長すぎます。32文字以内にしてください";
                    return false;
                }
                if(pass.value!==pass2.value)
                {
                    warning2.innerHTML="パスワードが違います。";
                    return false;
                }
            //何もなければ、trueで送信できる
                return true;
            }
    </script>
</body>
</html>
