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
        unset($_SESSION['manager']);
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
    <form action="" method="post">
    <body>
    <div class='color'>
    
    <div class='login'>
    <br>
    <h1>ログインページ</h1>

<?php
    if(isset($_POST['check'])){
        $uname = " ";
        $pass = " ";

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

        if ($result != false){
            $_SESSION['user_name'] = $uname;
            $_SESSION['pass'] = $pass;
            $_SESSION['manager'] = "";//初回ログインは管理者で入る

            header("Location:home.php");
            exit;
        }else{
            echo "<font color='red'>もう一度入力してください</font>";
            echo "<br>";
            echo "<font color='red'>ユーザーID、またはパスワードが間違っています。</font>";
            echo "<br><br>";        
    }
  
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