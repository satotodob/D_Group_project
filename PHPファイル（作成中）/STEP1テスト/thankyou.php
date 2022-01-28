<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>お会計済みダミーページ</title>
</head>
<style>
    body{
        text-align: center;
        background-color:#D7EEFF;
    }
</style>

<?php
    session_start();
    unset($_SESSION['manager']);//管理者認証をはずす
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
    <div class="msg">
                <h1>
                お会計完了<br>
                ご利用ありがとうございました。
                </h1>
    </div>

        <script>
            setTimeout(function(){
                window.location.href = 'category.php';
                }, 3*1000); //3秒後に画面遷移する
        </script>

</body>
</html>