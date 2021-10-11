
    <?php 
    require_once('../dbc/sraff_dbc.php');
    session();
      unset($_SESSION['imgname']) ;
      unset($_SESSION['imgname_right']); 
      unset($_SESSION['imgname_left']) ;
      unset($_SESSION['imgname_back']) ;
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
   ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品リスト</title>
</head>
<body>
    <div id="wrapper">
    <p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <header>
        <ul>
        <li><a href="../staff/staff_list.php">スタッフ管理</a></li>
        <li><a href="pro_list.php">商品管理</a></li>
        <li><a href="../login/staff_logout.php">ログアウト</a></li>
        </ul>
    </header>
<div id="mainlist">    
<h1>商品一覧</h1>
<table id="table">
<form method="post" action="pro_branch.php">
 <tr><th></th><th>商品コード</th><th>商品名</th><th>商品価格</th><th>消費税</th><th>在庫数</th></tr>             
 <?php foreach($all_aitems as $all_aitem):?>
    <tr id="listtr"> 
   <td><input type="radio" name="procode" value= "<?php echo  $all_aitem['id']?>"></td>
   <td><?php echo $all_aitem['cood'] ?></td><td><?php echo $all_aitem['name'] ?></td><td><?php echo $all_aitem['price'] ?>円</td>
   <td><?php echo $all_aitem['tax'] ?>%</td><td><?php echo $all_aitem['quantiry'] ?>個</td>
   </tr>
 <?php endforeach ?>
 
</table> 
<nav>       
 <input type="submit" name="edit" value="修正">
 <input type="submit" name="delete" value="削除">
 <input type="submit" name="add" value="追加">
 <input type="submit" name="disp" value="参照">
 <input type="submit" name="quantity" value="商品数追加">
</nav>
 </form>
 <a href="/staff_top.php">トップページへ</a>
</div>
</div>
    
</body>
</html>
