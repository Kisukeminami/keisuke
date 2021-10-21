
    <?php 
    require_once('../dbc/sraff_dbc.php');
//ログインしているか確認
    session();
//スタッフの権限確認、3番強い権限、以下なら別ページに飛ばす
    anthority_forse();
    try 
    {
        

    
        $dbh= new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        ]);
    //shop_staffから取得
        $sql ='SELECT staff_code, name FROM shop_staff ';
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        $dbh=null;
    
        
        //$all_staffsに全権入れる,fetchAllで
        $all_staffs=$stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>スタッフリスト</title>
</head>
<body>
<div id="wrapper">
<p id=sess>
<p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
</p>
    <header>
        <ul>
        <li><a href="../top/staff_top.php">トップページへ</a></li>
        <li><a href="../syouhinn/pro_list.php">商品管理</a></li>
        <li><a href="../login/staff_logout.php">ログアウト</a></li>
        </ul>
    </header>
    <div id=mainlist>
        <h1>スタッフ一覧</h1>
        <form method="post" action="staff_branch.php">
            <!-- $all_staffsをforeachで回していく -->
        <?php foreach($all_staffs as $all_staff):?>
        <input type="radio" name="staff_code" value= "<?php echo  $all_staff['staff_code']?>"><?php echo $all_staff['name'] ?>
        <br>
        <?php endforeach ?>
        <nav>        
        <input type="submit" name="edit" value="修正">
        <input type="submit" name="delete" value="削除">
        <input type="submit" name="add" value="追加">
        <input type="submit" name="disp" value="参照">
        </nav>
        </form>
    </div>
</div>
    
</body>
</html>
