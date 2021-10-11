<?php 
require_once('../dbc/sraff_dbc.php');
session();
anthority_sarede();
$staff_code=$_GET['staff_code'];
try {
   

    $dbh= new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    ]);

    $sql ='SELECT name ,anthority FROM shop_staff WHERE staff_code=?';
    $stmt=$dbh->prepare($sql);
    $date[]=$staff_code;
    $stmt->execute($date);
    $staff=$stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name=$staff['name'];
    $staff_anthority=$staff['anthority'];
    $dbh=null;


    } catch (PDOException $e) {
    echo "接続失敗".$e->getMessage();
    exit();

}
switch($staff_anthority){
    case 1:
        $anthority="部長";
        break;
    case 2:
        $anthority="課長";
        break;
    case 3:
        $anthority="社員";
        break;
    case 4:
        $anthority="不正規";
        break;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>スタッフ情報</title>
</head>
<body>
    <div id="wrapper">
    <p><?php echo $_SESSION["staff_name"]."さんログイン中です" ?></p>
    <h1>スタッフ情報</h1>
    <br>
    <h2><?php echo $staff_name ?> </h2>
    <h2>スタッフコード</h2>
    <h3><?php echo $staff_code ?></h3>
    <h2>役職</h2>
    <h3><?php echo $anthority ?></h3>

     <input type="button" onclick="history.back()" value="戻る">
     </div>
    </form>
</body>
</html>
