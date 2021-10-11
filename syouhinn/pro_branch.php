<?php 
var_dump($_POST);
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
        echo "ログインされていません";
        echo '<a href="/staff_login.php">ログイン画面へ</a>';
        exit();
    
};
if(empty($_POST['procode'])){
    if(isset($_POST['add'])){

        $pro_code=$_POST['pro_code'];
    
        header('Location:pro_add.php?pro_code='.$pro_code);
        exit();
    
    }else{
        echo "NG";
        header("Location:pro_ng.php");
        exit();
    }
}else if(isset($_POST['edit'])){
    echo "OK";
    $pro_code=$_POST['procode'];

    header('Location:pro_edit.php?pro_code='.$pro_code);
     exit();
}elseif(isset($_POST['delete'])){
    echo "lo";
    $pro_code=$_POST['procode'];

    header('Location:pro_delete.php?pro_code='.$pro_code);
    exit();

}elseif(isset($_POST['add'])){

    $pro_code=$_POST['procode'];

    header('Location:pro_add.php?pro_code='.$pro_code);
    exit();

}elseif(isset($_POST['disp'])){
    $pro_code=$_POST['procode'];

    header('Location:pro_disp.php?pro_code='.$pro_code);
    exit();

}else{
    $pro_code=$_POST['procode'];

    header('Location:pro_quantity.php?pro_code='.$pro_code);
    exit();

}
