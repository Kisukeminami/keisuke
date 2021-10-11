<?php 
require_once('../dbc/sraff_dbc.php');
    severrq();
    session();
    if(!isset($_SESSION['id'])):
		exit("直接アクセス禁止");
	endif;
	session_regenerate_id(true);
    $post=sanitize($_POST);
    $pro_quantiry=$post['quantiry'];
    $pro_name=$post['name'];
    $pro_id=$post['id'];
    $errors=array();
    if ((isset($pro_quantiry) && strlen($pro_quantiry))==false) {
        $errors['quantiry']="個数が入力されていません <br>";
    }
    ?>
    <html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品個数変更</title>
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
    <h3><?php echo $pro_name ?></h3> 
    <?php echo $pro_quantiry ?>個<br>
    <P>にいたしますか？</P>
    <form method="post" action="pro_quantiry_done.php">
    <input type="hidden"name="id" value="<?php echo  $pro_id ?>"> 
    <input type="hidden"name="name" value="<?php echo  $pro_name ?>"> 
    <input type="hidden"name="quantiry" value="<?php echo  $pro_quantiry ?>">    
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
    <?php endif ?>
    </div> 
</body>
