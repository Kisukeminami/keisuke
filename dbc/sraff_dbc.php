<?php 

function session(){
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) {
        echo "ログインされていません";
        echo '<a href="../login/staff_login.php">ログイン画面へ</a>';
        exit();
    }
}

$dsn='mysql:host=mysql152.phy.lolipop.lan;dbname=LAA1354465-3730kagu;charset=utf8';

$user='LAA1354465';

$pass='Minami3730';

function severrq(){
    if ($_SERVER["REQUEST_METHOD"]!=="POST") {
        echo "不正アクセスです";
        exit();
    }
}
function anthority_top(){
    if($_SESSION['staff_anthority'] >1){
        header('location:staff_anthority.html');
        exit();
    }
}

function anthority_second(){
    if($_SESSION['staff_anthority'] > 2){
        header('location:staff_anthority.html');
        exit();
    }
}
function anthority_sarede(){
    if($_SESSION['staff_anthority'] > 3){
        header('location:staff_anthority.html');
        exit();
    }
}
function anthority_forse(){
    if($_SESSION['staff_anthority'] > 4){
        header('location:staff_anthority.html');
        exit();
    }
}

function sanitize($before){
    foreach ($before as $key => $value) {
        $after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}
?>
