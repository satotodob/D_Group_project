<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <style>
        form{
            text-align: center;
        }
        h2{
            size:100; 
            color:RED;  
         }
    </style>
    
    <body>
    <form method ="post" action="">
        <h2>エラー</h2>
        <h3>データベースに接続できませんでした</h3>
        <input type = "submit" name= "rogin_page" value= "ログインページへ戻る">
    </form>
    </body>
    <?php
    session_start();
    //ログインページに行くのでセッションの情報を削除
    unset($_SESSION['uname']);//session 'userName'を削除 unset
    unset($_SESSION['pass']);//session 'Password'を削除 unset
    $_SESSION = array();
    setcookie(session_name(), '', time()-1, '/');
    session_destroy();
    if(isset($_POST['rogin_page'])){
        header("Location:index.php");
    }
    ?>
   
</html>

