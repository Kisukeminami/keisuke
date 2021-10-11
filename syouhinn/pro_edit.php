<?php 

require_once('../dbc/sraff_dbc.php');

session();
session_regenerate_id(true);
$_SESSION['id']=date('His');
anthority_sarede();
if(isset($_SESSION['imgname']) && $_SESSION['imgname']!==""):
    unlink($_SESSION['imgname']);
    $_SESSION['imgname']=array();
endif;
if(isset($_SESSION['imgname_right'])&& $_SESSION['imgname_right']!==""):
    unlink($_SESSION['imgname_right']);
    $_SESSION['imgname_right']=array();
endif;
if(isset($_SESSION['imgname_left'])&& $_SESSION['imgname_left']!==""):
    unlink($_SESSION['imgname_left']);
    $_SESSION['imgname_left']=array();
endif;
if(isset($_SESSION['imgname_back']) && $_SESSION['imgname_back']!==""):
    unlink($_SESSION['imgname_back']);
    $_SESSION['imgname_back']=array();
endif;
$pro_code=$_GET['pro_code'];
try {
 


    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT * FROM shop_list JOIN list_detail ON shop_list.cood = list_detail.cood JOIN sach ON shop_list.cood = sach.cood WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$pro_code;
    $stmt->execute($date);
    $all_aitems=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh=null;

    
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
    <title>商品修正</title>
</head>
<body>
<div id="wrapper">    
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
<?php foreach($all_aitems as $all_aitem):?>
    <form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
     <input type="hidden" name="pro_code" value="<?php echo $pro_code?>">
     <h3>商品名</h3>
     <input type="text" name="name" style="width: 200px" value="<?php echo $all_aitem['name'] ?>">
     <h3>コード</h3>
     <input type="text" name="cood" style="width: 200px" value="<?php echo $all_aitem['cood'] ?>">
     <input type="hidden" name="cood_old" value="<?php echo $all_aitem['cood']?>">
     <h3>商品価格</h3>
     <input type="text" name="price" style="width: 200px" value="<?php echo $all_aitem['price'] ?>"> 
     <h3>商品説明</h3>
     <textarea name="text" name="text" cols="30" rows="10" value=""><?php echo $all_aitem["text"] ?></textarea>
     <h3>商品サイズ</h3>
     <input type="text" name="size" style="width: 200px" value="<?php echo $all_aitem['size'] ?>">  
     <br> 
     <h3>商品個数</h3>
     <input type="text" name="quantiry" style="width: 200px" value="<?php echo $all_aitem['quantiry'] ?>">  
     <br> 
     <h3>消費税</h3>
     <input type="text" name="tax" style="width: 200px" value="<?php echo $all_aitem['tax'] ?>">  
     <br> 
     <h3>メーカー</h3>
     <input type="text" name="maker" style="width: 200px" value="<?php echo $all_aitem['maker'] ?>">
    <br>
    <h3>ジャンル</h3>
    <input type="text" name="genle" style="width: 200px" value="<?php echo $all_aitem['genre'] ?>">
    <h3>カテゴリー</h3>
    <?php $check1="" ?>
    <?php $check2="" ?>
    <?php $check3="" ?>
    <?php $check4="" ?>
    <?php switch($all_aitem['category']){
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
    }?>
        <input type="radio" name="category" <?php echo $check1 ?> value="1">テーブル<br>
        <input type="radio" name="category" <?php echo $check2 ?> value="2">イス<br>
        <input type="radio" name="category" <?php echo $check3 ?> value="3">ソファー<br>
        <input type="radio" name="category" <?php echo $check4 ?> value="4">その他<br>
    <br>
    <h3>商品メイン画像</h3>
    <img src="image/<?php echo $all_aitem['file_path']?>">
    <?php $pro_file_path_old=$all_aitem['file_path']?>
    <input type="hidden" name="file_path_old" value="<?php echo $pro_file_path_old ?>" >
    <br>
    <h3>画像を選んでください</h3>
    <input type="file" name="pro_file_path" style="width:400px">
    <p>画像を変更しない場合画像を選択しなくても問題ありません</p>

    <br>
    <h3>商品右画像</h3>
    <img src="image/<?php echo $all_aitem['file_path_right']?>">
    <?php $pro_file_path_right_old=$all_aitem['file_path_right']?>
    <input type="hidden" name="file_path_right_old" value="<?php echo $pro_file_path_right_old ?>" >
    <br>
    <h3>画像を選んでください</h3>
    <input type="file" name="pro_file_path_right" style="width:400px">
    <p>画像を変更しない場合画像を選択しなくても問題ありません</p>

    <br>
    <h3>商品後ろ画像</h3>
    <img src="image/<?php echo $all_aitem['file_path_back']?>">
    <?php $pro_file_path_back_old=$all_aitem['file_path_back']?>
    <input type="hidden" name="file_path_back_old" value="<?php echo $pro_file_path_back_old ?>" >
    <br>
    <h3>画像を選んでください</h3>
    <input type="file" name="pro_file_path_back" style="width:400px">
    <p>画像を変更しない場合画像を選択しなくても問題ありません</p>

    <br>
    <h3>商品左画像</h3>
    <img src="image/<?php echo $all_aitem['file_path_left']?>">
    <?php $pro_file_path_left_old=$all_aitem['file_path_left']?>
    <input type="hidden" name="file_path_left_old" value="<?php echo $pro_file_path_left_old ?>" >
    <br>
    <h3>画像を選んでください</h3>
    <input type="file" name="pro_file_path_left" style="width:400px" >
    <p>画像を変更しない場合画像を選択しなくても問題ありません</p>
    <?php endforeach?>
    <br>
     <input type="button" onclick="history.back()" value="戻る">
     <input type="submit" value="OK">

    </form>
    </div>
</body>
</html>
