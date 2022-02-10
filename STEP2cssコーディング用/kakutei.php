<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>確定</title>
  <style>

  </style>

</head>

<?php
    session_start();
    
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