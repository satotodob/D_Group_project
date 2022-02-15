<!DOCTYPE html>
<html>
    <head>
        <title>接続エラー</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/error.css">
    </head>
    <style>

    </style>
    
    <body>
    <form method ="post" action="">
        <div class = "a">
        <h2>エラー</h2>
        <h3>データベースに接続できませんでした</h3>
        </div>
        <div class="backlogin">
        <input type = "submit" name= "rogin_page" value= "ログインページへ戻る">  
        </div> 
    </body>
    <?php
        session_start();
        //ログインページに行くのでセッションの情報を削除
        unset($_SESSION['user_name']);//session 'username'を削除 unset
        unset($_SESSION['pass']);//session 'password'を削除 unset
        unset($_SESSION['manager']);//管理者確認　session 'manager'を削除
        $_SESSION = array();
        setcookie(session_name(), '', time()-1, '/');
        session_destroy();

        if(isset($_POST['rogin_page'])){
        header("Location:index.php");
        }
    ?>
   
</html>

