<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <?php
   require_once "All.php";
   $dbconnect = new connect();  
    ?>
    <style>
        form{
            text-align: center;
        }
    </style>
    <form action="" method="post">
    <body>
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
    $sql = null;
        if ($result != false){
            header("Location:kanri.php");
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
        <input type="submit" value="送信" name="check" >
      
    </body>
    </form>
</html>