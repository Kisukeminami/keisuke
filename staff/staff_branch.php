<?php 

require_once('../dbc/sraff_dbc.php');
//ログインしているか確認
session();
/*
以下、前画面から送られた、staff_codeを各ページに振り分けていく
ファイル、swite文の方が見やすいのかも
*/
if(empty($_POST['staff_code']))
{
    
    if (isset($_POST['add'])) 
    {
        $staff_code=$_POST['staff_code'];
        header('Location:staff_add.php?staff_code='.$staff_code);
        exit();
    }
    else
    {
        //そもそも指定しなければNGページに飛ばす
    header("Location:staff_ng.php");
    exit();
    }
}
else if(isset($_POST['edit']))
{
    
    $staff_code=$_POST['staff_code'];
    header('Location:staff_edit.php?staff_code='.$staff_code);
     exit();
}elseif(isset($_POST['delete']))
{

    $staff_code=$_POST['staff_code'];
    header('Location:staff_delete.php?staff_code='.$staff_code);
    exit();

}elseif(isset($_POST['add']))
{
    $staff_code=$_POST['staff_code'];
    header('Location:staff_add.php?staff_code='.$staff_code);
    exit();

}else
{
    $staff_code=$_POST['staff_code'];
    header('Location:staff_disp.php?staff_code='.$staff_code);
    exit();

};

?>
