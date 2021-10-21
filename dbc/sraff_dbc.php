<?php 
//ログインしているか確認命令
function session()
{
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login'])==false) 
    {
        echo "ログインされていません";
        echo '<a href="../login/staff_login.php">ログイン画面へ</a>';
        exit();
    }
}
//$dsnにホスト名とDB名、utf8を代入
$dsn='＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊';
//ユーザー名代入
$user='＊＊＊＊＊';
//パスワードを代入
$pass='＊＊＊＊＊';
//POST送信以外のアクセスを防ぐ
function severrq()
{
    if ($_SERVER["REQUEST_METHOD"]!=="POST")
     {
        echo "不正アクセスです";
        exit();
    }
}
//スタッフの権限確認、1番強い権限、以下なら別ページに飛ばす
function anthority_top()
{
    if($_SESSION['staff_anthority'] >1)
    {
        header('location:staff_anthority.html');
        exit();
    }
}
//スタッフの権限確認、2番強い権限、以下なら別ページに飛ばす
function anthority_second()
{
    if($_SESSION['staff_anthority'] > 2){
        header('location:staff_anthority.html');
        exit();
    }
}
//スタッフの権限確認、3番強い権限、以下なら別ページに飛ばす
function anthority_sarede()
{
    if($_SESSION['staff_anthority'] > 3)
    {
        header('location:staff_anthority.html');
        exit();
    }
}
//スタッフの権限確認、3番強い権限、以下なら別ページに飛ばす
function anthority_forse()
{
    if($_SESSION['staff_anthority'] > 4)
    {
        header('location:staff_anthority.html');
        exit();
    }
}
//引数の値をエスケープする
function sanitize($before)
{
    foreach ($before as $key => $value) 
    {
        $after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}
?>
