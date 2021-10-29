<?php 
require_once('../dbc/sraff_dbc.php');
session_start();
session_regenerate_id(true);
$_SESSION['cart_ng']=false;
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

//カートに商品が入っているか
if(isset($_SESSION['cart'])==false){
    
exit("商品がカートに入っていません");
}
$cart=$_SESSION['cart'];
$count=$_SESSION['count'];
$max=count($cart);
try {
    


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//カート分だけテーブルから拾ってくる。
    foreach ($cart as $key=>$value) 
    {
        $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $date[0]=$value;
        $stmt->execute($date);
        $disp_aitems=$stmt->fetch(PDO::FETCH_ASSOC);

        //qrint_r(array_column($disp_aitems,'name'));

    $disp_name[]=$disp_aitems['name']; 
    $disp_id[]=$disp_aitems['id'];
    $disp_price[]=$disp_aitems['price']; 
    $disp_size[]=$disp_aitems['size']; 
    if( $disp_aitems["category"] === "1"):
        $disp_ctegory[]="テーブル";
     elseif($disp_aitems["category"] === "2"):
        $disp_ctegory[]="イス";

    elseif($disp_aitems["category"] === "3"): 
        $disp_ctegory[]="ソファー";

     else :
        $disp_ctegory[]="その他";

      endif ;
     $disp_image[]=$disp_aitems['file_path'];
     $disp_quantiry[]=$disp_aitems['quantiry'];
    }
    

 

    } catch (PDOException $e) {
    echo "接続失敗".$e->getMessage();
    exit();

}
$tatalprice=0;
$dbh=null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報</title>
</head>
<body>
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
    <h1>商品情報</h1>
    <br>
 <form method="post" action="count.php">
<?php 

?>
<!--  カートに入っている商品の表示、在庫がなければ削除と数量、変更を促す-->
        <?php for($i=0;$i<$max;$i++):?>
            <?php if($disp_quantiry[$i]>=$count[$i]):?>
        <h3><?php echo $disp_name[$i] ?></h3>
        <h3><?php echo $disp_price[$i] ?></h3>
        <h3><?php echo $disp_size[$i] ?></h3>
        <img src="../syouhinn/image/<?php echo $disp_image[$i]?>" width="200px" height="200px">
        <input type="number" name="count<?php echo $i;?>" value="<?php echo $count[$i];?>"max="<?php echo $disp_quantiry[$i]?>">
        削除：<input type="checkbox" name="delete<?php echo $i ?>"> 
        <?php 
        $price=$disp_price[$i]*$count[$i];
        $tatalprice+=$price ;
        else:
        ?>
        <h3><?php $_SESSION['cart_ng']=true;
         echo $disp_name[$i]?>は在庫切れです</h3>
        <img src="../syouhinn/image/<?php echo $disp_image[$i]?>" width="200px" height="200px">
        <input type="number" name="count<?php echo $i;?>" value="<?php echo $count[$i];?>"max="<?php echo $disp_quantiry[$i]?>">
        <input type="checkbox" name="delete<?php echo $i ?>"> 
        <P>こちらの商品の数量を変更するか削除してください</P>
        <?php 
        endif;
        endfor;
        var_dump($cart); 
        ?>
   
    <h3>カート合計金額：<?php echo $tatalprice ?></h3>

<br>
<input type="hidden" name="max" value="<?php echo $max ;?>">
<input type="submit" value="削除or数量変更">

</form>

<a href="shop_by.php">購入</a>
<a href="list.php">戻る</a>
