<?php 
require_once('../dbc/shop_dbc.php');
session_start();
session_regenerate_id(true);
$cart=$_SESSION['cart'];
$count=$_SESSION['count'];
$pass=$_SESSION['pass'];
$max=count($cart);
$flag=false;
//商品の在庫がなければflagが立っている
if($_SESSION['cart_ng']===true){
  header('Location:shop_cart_list.php');
  exit();
}
//セッションネームに値があれば（ログイン状態）ログイン状態にするため、flag=trueに変える
if(isset($_SESSION['name'])) 
{
    $flag=true;
    
}

if ($flag===true && empty($_SESSION['aitem_by'])) 
{
    $pdo=shop\dbconect();
    //ユーザーテーブルから必要な情報を所得
    $stmt=$pdo->prepare("SELECT*FROM `youser_sin` WHERE pass=?");
    $date[]=$pass;
    $stmt->execute($date);
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $mail=$result['mail'];
    $post=$result['post'];
    $zyu=$result['zyu'];
    $tel=$result['tel'];

    $stmt=null;
    //カートの分だけ
    foreach ($cart as $key=>$value) {
        $sql ='SELECT * FROM shop_list WHERE id=?';
        $stmt=$pdo->prepare($sql);
        $date=array();
        $date[0]=$value;
        $stmt->execute($date);
        $disp_aitems=$stmt->fetch(PDO::FETCH_ASSOC);
        $disp_name[]=$disp_aitems['name'];
        $disp_price[]=$disp_aitems['price'];

        $name=$disp_aitems['name'];
        $price=$disp_aitems['price'];
    }
    $mail_body=0;
    for ($i=0;$i<$max;$i++) {
        $stmt=$pdo->prepare("INSERT INTO shop_order(cood,pro_name,price,quantiry,mail,post,tel,zyu,flag) VALUES(?,?,?,?,?,?,?,?,?)");
        $date=array();
        $date[]=$cart[$i];
        $date[]=$disp_name[$i];
        $date[]=$disp_price[$i];
        $date[]=$count[$i];
        $date[]=$mail;
        $date[]=$post;
        $date[]=$tel;
        $date[]=$zyu;
        $date[]=0;
        $result=$stmt->execute($date);
        $counts=$count[$i];
        $aitem_prise=$counts*$price[$i];
        $mail_body.=$name;
        $mail_body.=$price.'円×';
        $mail_body.=$counts.'個';
        $mail_body.=$aitem_prise."円 ￥n";
    }

  if ($result) 
  {
      $subject="商品のご購入";
      mb_language('japanese');
      mb_internal_encoding('UTF-8');
      $body = <<< EOM
      この度はご購入ありがとうございます。
      こちらの商品の購入を確認しました。
      {$mail_body}
      送料は無料です。
      
    EOM;
      $from='info@bold-saito-0728.bambina.jp';
      $result1=mb_send_mail($mail, $subject, $body, $from);
      $result1=true;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

</head>
<body>
<header>
  <div id="upmain">
    <!--ログインしていれば-->
  <?php if($flag): ?>
    <h3><?php echo $_SESSION['name'] ?>様</h3>
    <p>いらっしゃいませ</p>
    <?php 
    if(isset($img)):
    ?>
       <img src="../yuser/<?php  echo $img?>"width="50px" height="50px">
    <?php 
    endif; 
    ?> 
  <?php 
var_dump($_SESSION['aitem_by']);
var_dump(empty($_SESSION['aitem_by']));
if(isset($result1)):
  
    if(empty($_SESSION['aitem_by'])):
      header('location:aitem_by.php');
    /*elseif($_SESSION['aitem_by']==1):
      $_SESSION['aitem_by']=array();
      $_SESSION['cart']=array();
      $_SESSION['count']=array();*/
      ?>
    
    <?php
    endif;
    ?> 
<?php 
elseif($_SESSION['aitem_by']==1):
      $_SESSION['aitem_by']=array();
      $_SESSION['cart']=array();
      $_SESSION['count']=array();
?>
  <h3>商品購入いたしました。</h3>
    <a href="list.php">こちらからお戻りください</a>
<?php 
else:
?>  
　<h3>サーバーエラーです戻ってやり直してください</h3>
<?php
endif;

?>
  <!-- ログインしていなければ-->
  <?php else: ?> 
    <h3>ゲストユーザー様</h3>
    <p>いらっしゃいませ</p>
    <p>購入は会員様以外受けつけておりません、すでに会員の方はログインしてください</p>
    <a href="./login.php">会員ログイン</a>
  <?php endif; ?> 
</div>
</header>
</body>
</html>
