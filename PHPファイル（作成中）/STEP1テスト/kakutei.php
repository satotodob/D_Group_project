<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>確定</title>
  <link rel="stylesheet" href="./style.css">

</head>

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
        <div class="login">
            <div class="form">
                <h2>
                ご注文ありがとうございます。<br>
                ご注文が確定しました。しばらくお待ちください。
                </h2>
            </div>
        </div>

        <script>
            setTimeout(function(){
                window.location.href = 'category.php';
                }, 5*1000); //5秒後に画面遷移する
        </script>

</body>
</html>