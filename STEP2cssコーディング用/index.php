<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <?php
        session_start();
        require_once "db_connect.php";
        $dbconnect = new connect();
        
    ?>
    <style>
        form{
           
            
        }
        body{
            background-color :#c0c0c0;
            text-align: center;
        }
        
        h1{
            font-size:25px;
            color:#191970;
        }
        
        .login {
            /*background-color : #ffdab9;*/
            width: 500px;
            margin: 150px auto;
            font-size: 16px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .login input{
            box-sizing: border-box;
            display: block;
            width: 100%;
            border-width: 1px;
            border-style: solid;
            padding: 11px;
            font-family: inherit;
            font-size: 0.95em;
        }
        
        /*.login input:hover {
            text-decoration: none;
            background-color:#8d8d8d;
        }*/
        
        
        .color{
            background-color :#dcdcdc;
            height:auto;
        
        }
        
    </style>
    <form action="" method="post" enctype="multipart/form-data">
    <body>
    <div class='color'>
    
    <div class='login'>
    <br>
    <h1>ログインページ</h1>

<?php
    if(isset($_POST['check'])){
        $uname = " ";
        $pass = " ";

        if(isset($_FILES['filedata']['name'])){
            if($_FILES['filedata']['name'] == "terminal.ini"){ //正しくアップされた場合
                $ini_import = parse_ini_file($_FILES['filedata']['tmp_name'], true);
                $table_no = $ini_import["number"];
                $_SESSION['table_no'] = $table_no;
            }else{
                if(empty($_FILES['filedata']['name'])){ //アップされていない
                    print('<br><font color="red">ファイルがアップロードされていません</font><br>');
                }else{ //アップされたファイルがterminal_ini以外
                    print('<br><font color="red">「terminal.ini」ファイル以外はアップロードできません</font><br>');
                }
            }
        }

        if($_POST['uname']){
        $uname= ($_POST["uname"]);
        }
        if($_POST['pass']){
        $pass = ($_POST["pass"]);
        }

        $sql = $dbconnect ->db->prepare('SELECT * FROM user_table WHERE user_name=? and Password=?');
        //$sql = $dbconnect->prepare($sql);
        $sql->execute(array($uname,$pass));
        $result = $sql->fetch();
        $sql = null;

        if ($result != false && isset($_SESSION['table_no'])){
            $_SESSION['user_name'] = $uname;
            $_SESSION['pass'] = $pass;
            $_SESSION['manager'] = "";//初回ログインは管理者で入る

            header("Location:home.php");
            exit;
        }else if($result != false && !isset($_SESSION['table_no'])){
        }else{
            echo "<font color='red'>もう一度入力してください</font>";
            echo "<br>";
            echo "<font color='red'>ユーザーID、またはパスワードが間違っています。</font>";
            echo "<br><br>";
        }     
}
?>
    <?php 
        if(!isset($_SESSION['table_no'])){ //table_noのセットが出来ていない時だけ表示
    ?>
        卓番号：<input type="file" name="filedata">
        <br><br>
    <?php 
        }else{
            print('<br>卓番号が「'.$_SESSION['table_no'].'」でセットされています<br>');
        }
    ?>
    
        ユーザーID：<input typw="text" name="uname" value="" required>
        <br>
        パスワード：<input type="password" name="pass" size="20" value=""  required>
        <br>
        <br>
        <input type="submit" value="ログイン" name="check" >
        <br>
        </div> 
        </div>
    </body>
    </form>
</html>