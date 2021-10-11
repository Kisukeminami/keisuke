<?php 
require_once('../dbc/sraff_dbc.php');

session();

session_regenerate_id(true);
$_SESSION['id']=date('His');
if(isset($_SESSION['imgname'])):
    unlink($_SESSION['imgname']);
    $_SESSION['imgname']=array();
endif;
if(isset($_SESSION['imgname_right'])):
    unlink($_SESSION['imgname_right']);
    $_SESSION['imgname_right']=array();
endif;
if(isset($_SESSION['imgname_left'])):
    unlink($_SESSION['imgname_left']);
    $_SESSION['imgname_left']=array();
endif;
if(isset($_SESSION['imgname_back'])):
    unlink($_SESSION['imgname_back']);
    $_SESSION['imgname_back']=array();
endif;
?><!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>商品追加</title>
</head>
<body>
<div id="wrapper">
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>商品追加</h1>
       <form method="post" action="pro_add_check.php" enctype="multipart/form-data">
       <table>
       <tr><th>商品名</th><th>商品コード</th><th>商品画像</th></tr>
        <tr><td>
        <input type="text" id=name name="name" >
        <p></p>
        </td>
        <td>
        <input type="text" id=cood name="cood">
        </td>
        <td>
        <input type="file" id=image name="image">
        </td>
        </tr><br>
        <tr>
        <th>価格</th><th>商品個数</th><th>商品説明を入力してください</th>
        </tr>
        <tr>
        <td>
        <input type="text" id=price name="price">
        </td>
        <td>
        <input type="text" id=quantiry name="quantiry" style="width: 100px"></td>
        <td>
        <textarea name="text" id=text name="text" cols="30" rows="10"></textarea>
        </td>
        </tr>
        <tr><th>消費税</th><th>商品サイズ</th><th>商品画像右</th></tr>
        <tr>
        <td>
        <input type="text" id=tax name="tax" value="10" style="width: 100px">
        </td>
        <td>
        <input type="text" id=size name="size" style="width: 300px">
        </td>
        <td>
        <input type="file" id=file_right name="file_path_right" style="width: 300px">
        </td>
        <tr><th>商品画像左</th><th>商品画像後ろ</th><th>メーカー</th></tr>
        <tr>
        <td>
        <input type="file" id=file_left name="file_path_left" style="width: 300px">
        </td>
        <td>
        <input type="file" id=file_back name="file_path_back" style="width: 300px">
        </td>
        <td>
        <input type="text" id="maker" name="maker">
        </td>
        </tr>
        <tr><th>ジャンル</th><th>カテゴリ</th></tr>
        <tr>
        <td>
        <input type="text" id="genle" name="genle">
        </td>
        <td>
        <input type="radio" name="category"value="1">テーブル
        <input type="radio" name="category"value="2">イス
        <input type="radio" name="category"value="3">ソファー
        <input type="radio" name="category"value="4">その他
        </td>
        </tr>
        </table>
        <input type="hidden" onclick="history.back()" valuse="戻る">
        <input type="submit" id="btn" value="OK">
    </form>
    <script>
    
        const name = document.forms[0].elements['name'].value
        const cood = document.forms[0].elements['cood'].value
        const image = document.forms[0].elements['image'].value
        const price = document.forms[0].elements['price'].value
        const text = document.forms[0].elements['text'].value
        const size = document.forms[0].elements['size'].value
        const file_path_right = document.forms[0].elements['file_path_right'].value
        const file_path_left = document.forms[0].elements['file_path_left'].value
        const file_path_back = document.forms[0].elements['file_path_back'].value
        const maker = document.forms[0].elements['maker'].value
        const genle = document.forms[0].elements['genle'].value
        const category = document.forms[0].elements['category'].value
        const btn=document.getElementById('btn');
        btn.onclick=function(){
            if(name.length==""){
                    warning.innerHTML="スタッフ名が入力されていません";
                    return false;
                }
        }
    </script>
    </div>
</body>
</html>
