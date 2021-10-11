<?php require_once('../dbc/sraff_dbc.php');
header('X-FRAME-OPTIONS: SAMEORIGIN');
 try {



  $dbh= new PDO($dsn, $user, $pass, [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  ]);
  
  $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $dbh=null;


  $all_aitems=$stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "接続失敗".$e->getMessage();
  exit();

}
session_start();
session_regenerate_id(true);
if(isset($_SESSION['menber_login'])==false)
{
 function yuser(){
     echo "ゲストユーザー";
     echo '<a href="menber_login.html">会員ログイン</a>';
 }
}else{
    function yuser()
    {
        echo "ようこそ".$_SESSION['menber_name']."様";
        echo '<a href="menber_logout.html">会員ログイン</a>';
    }
}
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
<div id="wraper">
<div class="header-right">
  <nav><?php yuser() ?></nav>
<ul>
<li><a href="snow.php">メンズ</a></li>
<li><a href="snow.php">レディース</a></li>
<li><a href="snow.php">キッズ</a></li>
</ul>
</div>
</header>

<ul clsss="images">
   <li class="image active">
   </li>
</ul>
<div class="image-btn-slide">
  <div class="image-btn">1</div>
  <div class="image-btn">2</div>
  <div class="image-btn">3</div>

</div>
<script type="text/javascript" src="script.js"></script> 
<div class="newItemu">
<h2>NEW ITEMU</h2>      
<?php foreach($all_aitems as $all_aitem):?>
   <a href="shop_disp.php?proid=<?php echo  $all_aitem['id']?>" >
   <img src="../syouhinn/image/<?php echo $all_aitem['file_path'] ?>" width="200px" height="300px">
   <?php echo $all_aitem['name'] ?><?php echo $all_aitem['price'] ?>
   <?php echo $all_aitem['text'] ?>
   </a>
 <?php endforeach ?>
 <br>
 <a href="shop_cart_list.php">カートを見る</a>

</div>
</div>
</body>
</html>
