<?php 

require_once('../dbc/sraff_dbc.php');
//ログインしているか確認命令
session();
//スタッフ権限確認
anthority_sarede();

?>
<!DOCTYPE html>
<html lang="ja">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style1.css">
<head>
    <meta charset="UTF-8">
    <title>スタッフぺージ</title>
</head>
<body>
<div id="wrapper">
    
<p><?php echo $_SESSION["staff_name"]."さんログイン中です"?></p>
    <h1>スタッフ追加</h1>
    <form method="post" action="staff_check.php">
        スタッフ名を入力してください<br>
        <input type="text" id=name name="name" style="width:100px"><br>
        <p  class="warning" id="warning"></p>
        
     <h3>役職</h3>
 
      <input type="radio" id="anthority" name="anthority"   value="1">部長
    　<input type="radio" id="anthority1" name="anthority"  value="2">課長
    　<input type="radio" id="anthority2" name="anthority"  value="3">社員
    　<input type="radio" id="anthority3" name="anthority"  value="4">非正規
    <p class="warning" id="warning0"></p>
        パスワード入力してください<br>
        <input type="password" id=pass name="pass" style="width:100px"><br>
        <p>パスワードは11文字以内かつ、半角英数、全角英語各一文字以上入れてください</p>
        <p class="warning"  id="warning1"></p>
        パスワードもう一度入力してください<br>
        <input type="password" id=pass2 name="pass2" style="width:100px"><br>
        <p class="warning" id="warning2"></p>
        <br>
        <input type="hidden" onclick="history.back()" value="戻る">
        <input type="submit" id=btn value="OK">
    </form>
</div>
    <script>
        //idの所得
            const name=document.getElementById('name');
            const btn=document.getElementById('btn');
            const pass=document.getElementById('pass');
            const pass2=document.getElementById('pass2');
            const anthority=document.getElementById('anthority');
            const anthority1=document.getElementById('anthority1');
            const anthority2=document.getElementById('anthority2');
            const anthority3=document.getElementById('anthority3');
            const warning=document.getElementById('warning');
            const warning0=document.getElementById('warning0');
            const warning1=document.getElementById('warning1');
            const warning2=document.getElementById('warning2');

            console.log(anthority.cheked);

            //OKボタンが押されたときに、スタッフ名がなければ、送れない
            btn.onclick=function(){
                if(name.value.length==""){
                    warning.innerHTML="スタッフ名が入力されていません";
                    return false;
                //スタッフ名が記入されていれば、何もしない    
                }else{
                    warning.innerHTML=="";

                }
                //スタッフ名の問題で、<p>タグに文字を出す
                if(15<=name.value.length){
                    warning.innerHTML="スタッフ名が長すぎます。15文字以内に下ください";
                    return false;
                }else{
                    warning.innerHTML="";
                }
                //チェックボックスにチェックが入っていなければ、<p>タグに文字を出す
                if((anthority.checked || anthority1.checked || anthority2.checked || anthority3.checked)==false){
                    warning0.innerHTML="役職が指定されていません";
                    return false;
                }else{
                    warning0.innerHTML="";
                }
                if(pass.value.length==""){
                    warning1.innerHTML="パスワードが入力されてないです。";
                    return false;
                }else{
                    warning1.innerHTML=""
                }
                if(11<=pass.value.length){
                    warning1.innerHTML="パスワードが長すぎます。11文字以内にしてください";
                    return false;
                }else{
                    warning1.innerHTML=""
                }
                //パスワードが一番目と二番目で確認
                if(pass.value!==pass2.value){
                    warning2.innerHTML="パスワードが違います。";
                    return false;
                }
            
                return true;
            }
         
            window.addEventListener('keydown', function(event) {
  
  console.log(event.keyCode);
  
});

        
    </script>
</body>
</html>
