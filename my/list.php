<?php require_once('../dbc/sraff_dbc.php');
header('X-FRAME-OPTIONS: SAMEORIGIN');
$flag=false;
 try 
 {



  $dbh= new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  ]);
  //shop_list、list_detail、sachを結合して全件取得
  $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $dbh=null;


  $all_aitems=$stmt->fetchAll(PDO::FETCH_ASSOC);

} 
catch (PDOException $e)
 {
  echo "接続失敗".$e->getMessage();
  exit();

}
session_start();
session_regenerate_id(true);
var_dump($_SESSION['name']);
//ユーザーがログイン状態かどうか判定
if(isset($_SESSION['name']))
{
  //フラグを立たせる
   $flag=true;
   $name=$_SESSION['name'];
   if(isset($_SESSION[`filename`]))
   {
    $img=$_SESSION[`filename`];
   }else
   {
     $img=null;
   }
}
else
{
        
        //echo '<a href="menber_logout.html">会員ログイン</a>';
    
}
var_dump($_SESSION['name']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>momono</title>

</head>
<body>
<header>
  <div id="upmain">
    <!-- フラグが立っていたら　ユーザーを表示 -->
  <?php if($flag): ?>
    <h3><?php echo $name ?>様</h3>
    <p>いらっしゃいませ</p>
      <?php if(isset($img)):?>
       <img src="../yuser/<?php  echo $img?>"width="50px" height="50px">
      <?php endif; ?>  
  <?php else: ?> 
    <h3>ゲストユーザー様</h3>
    <p>いらっしゃいませ</p>
    <a href="./login.php">会員ログイン</a>
  <?php endif; ?>  
  </div>
</header>
<div id="wraper">
<h2>NEW ITEMU</h2>
<div id="allaitem">      
<?php foreach($all_aitems as $all_aitem):?>
  <div id="newitemu">
  <a href="shop_disp.php?proid=<?php echo  $all_aitem['id']?>">
   <img src="../syouhinn/image/<?php echo $all_aitem['file_path'] ?>" width="200px" height="300px">
   <br>
   <h4><?php echo $all_aitem['name']?>
  　<?php echo $all_aitem['price']?>円（税抜き）</h4>
   <h4>商品説明</h4>
   <P><?php echo $all_aitem['text'] ?></P>
   </a>
   </div>
 <?php endforeach ?>
 </div>
 <a href="shop_cart_list.php">カートを見る</a>

</div>
</div>
</body>
</html>
