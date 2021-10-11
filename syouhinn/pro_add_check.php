    <?php
    
    require_once('../dbc/sraff_dbc.php');
    severrq();
    session();

	if(!isset($_SESSION['id'])):
		exit("直接アクセス禁止");
	endif;
	try {
        $pdo = new PDO($dsn,$user,$pass,
        array(PDO::ATTR_EMULATE_PREPARES => false));
    }
    catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
    }
    

    $post=sanitize($_POST);
    $pro_name=$post['name'];
    $pro_cood=$post['cood'];
    $pro_price=$post['price'];
    $pro_text=nl2br($post['text']);
    $pro_file_path=$_FILES['image'];
    $pro_quantiry=$post['quantiry'];
    $pro_tax=$post['tax'];
    $pro_size=$post['size'];
    $pro_file_path_right=$_FILES['file_path_right'];
    $pro_file_path_left=$_FILES['file_path_left'];
    $pro_file_path_back=$_FILES['file_path_back'];
    $pro_maker=$post['maker'];
    $pro_genle=$post['genle'];
    $pro_category=$post['category'] ?? "カテゴリーが選択されていません<br>";
    $errors=array();
    

    if((isset($pro_name) && strlen($pro_name))==false){
        $errors['name']="商品名が入力されていません <br>";
        }elseif(mb_strlen($pro_name)>30){
        $errors['name']="商品名が長いです30文字以内してください<br>";  
        }
        
        if ((isset($pro_cood) && strlen($pro_cood))==false) {
            $errors['cood']="商品コードが入力されていません <br>";
        }elseif(strlen($pro_cood)>10){
            $errors['cood']="10文字以内にいてください <br>";
        }else{
            $stmt=$pdo->prepare("SELECT `cood` FROM `shop_list`");
            $stmt->execute();
    
            while ($result=$stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($result['cood']===$pro_cood){
                    $errors["cood"]="この商品コードは既に登録されています";
                    break;
                }
            }
        }
   
      if((isset($pro_text) && strlen($pro_text))==false){
        $errors['text']="説明が入力されていません <br>";
        
    }elseif(strlen($pro_text)>254){
        $errors['text']="２５４文字以内にいてください <br>";
    }


    if ((isset($pro_size) && strlen($pro_size))==false) {
        $errors['size']="サイズが入力されていません <br>";
    }elseif(strlen($pro_size)>254){
        $errors['size']="サイズが長いです、254文字以内にしてください<br>";
    }

    
        if($pro_file_path['name']=="")
        {
            $errors['file_path']="メイン画像ファイルが指定されてないです";

        }elseif($pro_file_path["error"]!==0){
            switch($pro_file_path["error"]){
                case 3:
                $errors['file_path']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 4:
                $errors['file_path']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 6:
                $errors['file_path']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                case 7:
                $errors['file_path']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                default:
                $errors['file_path']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;

               }
            }elseif(strtolower($pro_file_path["name"])){
                $path_info =pathinfo($pro_file_path['name'],PATHINFO_EXTENSION);
                if(!($path_info=="jpg" || $path_info=="jpeg" || $path_info=="png")){
                    $errors['file_path']="画像の拡張子が違います";
                
                }elseif($pro_file_path['size']>1000000){
                $errors['file_path']="画像が大きすぎます";
            }else{
                $save_file_name=date('YmdHis').$pro_file_path["name"];
                move_uploaded_file($pro_file_path['tmp_name'],'image/'.$save_file_name);
                $_SESSION['imgname']='image/'.$save_file_name;
                echo "<br>";
         }  } 
            


    if ((isset($pro_quantiry) && strlen($pro_quantiry))==false) {
        $errors['quantiry']="個数が入力されていません <br>";
    }elseif(mb_strlen($pro_quantiry)>8){
        $errors['quantiry']="個数が多すぎます8個以下にしてください<br>";
    }

    if ((isset($pro_tax) && strlen($pro_tax))==false) {
        $errors['tax']="消費税が入力されていません <br>";
    }elseif(mb_strlen($pro_tax)>5){
        $errors['tax']="消費税が長いです5桁以下でお願いします<br>";
    }

    
    if ((isset($pro_maker) && strlen($pro_maker))==false) {
        $errors['maker']="メーカーが入力されていません <br>";
    }

    if ((isset($pro_genle) && strlen($pro_genle))==false) {
        $errors['genle']="ジャンルが入力されていません <br>";
    }elseif(mb_strlen($pro_genle)>255){
        $errors['genle']="ジャンルが長すぎます。255文字以下でお願いします。<br>";
    }
  
    if (preg_match('/^[0-9]+$/', $pro_price)==0) {
        $errors['price']="価格がきちんと入力されていません <br>";
    }elseif(mb_strlen($pro_price)>11){
        $errors['price']="価格の桁が多いです11桁以下にしてください<br>";
    }
  
    
 
if($pro_category == "1"){
        $new_category="テーブル";
    }elseif($pro_category == "2"){
        $new_category="イス";

    }elseif($pro_category == "3"){
     $new_category="ソファー";

    }elseif($pro_category == "4"){
        $new_category="その他";
    }else{
        $errors['category']=$pro_category;
        
    }   
    


        if($pro_file_path_right['name']=="")
        {
            $errors['file_path_right']="メイン画像ファイルが指定されてないです";

        }elseif($pro_file_path_right["error"]!==0){
            switch($pro_file_path_right["error"]){
                case 3:
                $errors['file_path_right']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 4:
                $errors['file_path_right']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 6:
                $errors['file_path_right']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                case 7:
                $errors['file_path_right']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                default:
                $errors['file_path_right']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;

               }
            }elseif(strtolower($pro_file_path_right["name"])){
                $path_info_right =pathinfo($pro_file_path_right['name'],PATHINFO_EXTENSION);
                if(!($path_info_right=="jpg" || $path_info_right=="jpeg" || $path_info_right=="png")){
                    $errors['file_path_right']="画像の拡張子が違います";
                
                }elseif($pro_file_path_right['size']>1000000){
                $errors['file_path']="画像が大きすぎます";
            }else{
                $save_file_name_right=date('YmdHis').$pro_file_path_right["name"];
                move_uploaded_file($pro_file_path_right['tmp_name'],'image/'.$save_file_name_right);
                $_SESSION['imgname_right']='image/'.$save_file_name_right;
                echo "<br>";
         }  } 

    
        if($pro_file_path_left['name']=="")
        {
            $errors['file_path_left']="メイン画像ファイルが指定されてないです";

        
    }elseif($pro_file_path_left["error"]!==0){
        switch($pro_file_path_left["error"]){
            case 3:
            $errors['file_path_left']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
            break;
            case 4:
            $errors['file_path_left']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
            break;
            case 6:
            $errors['file_path_left']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
            break;
            case 7:
            $errors['file_path_left']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
            break;
            default:
            $errors['file_path_left']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;

           }
        }elseif(strtolower($pro_file_path_left["name"])){
            $path_info_left =pathinfo($pro_file_path_left['name'],PATHINFO_EXTENSION);
            if(!($path_info_left=="jpg" || $path_info_left=="jpeg" || $path_info_left=="png")){
                $errors['file_path_left']="画像の拡張子が違います";
            
            }elseif($pro_file_path_left['size']>1000000){
            $errors['file_path_left']="画像が大きすぎます";
        }else{
            $save_file_name_left=date('YmdHis').$pro_file_path_left["name"];
            move_uploaded_file($pro_file_path_left['tmp_name'],'image/'.$save_file_name_left);
            $_SESSION['imgname_left']='image/'.$save_file_name_left;
            echo "<br>";
     }  } 


        if($pro_file_path_back['name']=="")
        {
            $errors['file_path_back']="メイン画像ファイルが指定されてないです";

        }elseif($pro_file_path_back["error"]!==0){
            switch($pro_file_path_back["error"]){
                case 3:
                $errors['file_path_back']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 4:
                $errors['file_path_back']="メイン画像ファイルにエラーが発生しました一度戻ってやり直してください" ;
                break;
                case 6:
                $errors['file_path_back']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                case 7:
                $errors['file_path_back']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;
                break;
                default:
                $errors['file_path_back']="メイン画像ファイルにエラーが発生しました担当者に連絡ください" ;

               }
            }elseif(strtolower($pro_file_path_back["name"])){
                $path_info_back =pathinfo($pro_file_path_back['name'],PATHINFO_EXTENSION);
                if(!($path_info_back=="jpg" || $path_info_back=="jpeg" || $path_info_back=="png")){
                    $errors['file_path_back']="画像の拡張子が違います";
                
                }elseif($pro_file_path_back['size']>1000000){
                $errors['file_path_back']="画像が大きすぎます";
            }else{
                $save_file_name_back=date('YmdHis').$pro_file_path_back["name"];
                move_uploaded_file($pro_file_path_back['tmp_name'],'image/'.$save_file_name_back);
                $_SESSION['imgname_back']='image/'.$save_file_name_back;
                echo "<br>";
         }  } 
     

        
         ?>
    <html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品追加</title>
</head>
<body>
<div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
<?php
        if(count($errors)):
		foreach($errors as $value):?>

	<p><?php echo $value; ?></p>
<?php
		endforeach;
   ?>     
        <input type="button" onclick="history.back()" value="戻る">
     <?php else: ?>
        <h3>商品名：　<?php echo $pro_name?></h3>

        <h3>商品コード：　<?php echo $pro_cood ?></h3>

        <h3>商品価格：　<?php echo  $pro_price ?></h3>
      
        <h3>商品説明</h3>
        <p><?php echo $pro_text ?></p>
       
        メイン画像<br>
        <img src="image/<?php echo $save_file_name ?>"whith:300px hight:300px>
        
        <h3>商品個数：　<?php echo $pro_quantiry ?></h3>
      
        <h3>消費税：　<?php echo  $pro_tax?>%</h3>
        
        <h3>メーカー：　<?php echo $pro_maker ?></h3>
        
        <h3>ジャンル：　<?php echo $pro_genle ?></h3>
       
        <h3>カテゴリー：　<?php echo $new_category ?></h3>
        
        左画像<br>
        <img src="image/<?php echo $save_file_name_left ?>" whith:300px hight:300px>
        <br>
        右画像<br>
        <img src="image/<?php echo $save_file_name_right ?>" whith:300px hight:300px>
        <br>
        後ろ画像<br>
        <img src="image/<?php echo $save_file_name_back ?>" whith:300px hight:300px>
        


    <form method="post" action="pro_add_done.php">
    <input type="hidden"name="name" value="<?php echo $pro_name?>">
    <input type="hidden"name="cood" value="<?php echo $pro_cood ?>">
    <input type="hidden"name="price" value="<?php echo  $pro_price ?>">
    <input type="hidden"name="text" value="<?php echo $pro_text ?>">
    <input type="hidden"name="size" value="<?php echo  $pro_size?>">
    <input type="hidden"name="quantiry" value="<?php echo $pro_quantiry ?>">
    <input type="hidden"name="tax" value="<?php echo  $pro_tax?>">
    <input type="hidden"name="maker" value="<?php echo $pro_maker ?>">
    <input type="hidden"name="genle" value="<?php echo $pro_genle ?>">
    <input type="hidden"name="category" value="<?php echo $pro_category ?>">
    <input type="hidden"name="file_path" value="<?php echo $save_file_name?>">
    <input type="hidden"name="file_path_right" value="<?php echo $save_file_name_right ?>">
    <input type="hidden"name="file_path_left" value="<?php echo $save_file_name_left ?>">
    <input type="hidden"name="file_path_back" value="<?php echo $save_file_name_back ?>">
    
   
    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
    <?php endif ?> 
    </div>
</body>
    </html>
