<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>確定</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
    <form action="" method="post">
        <div class="login">
            <div class="form">
            <h2>
                ご注文ありがとうございます。<br>
                ご注文が確定しました。しばらくお待ちください。
            </h2>

            <div class="form-field">
                <button type="submit" class="button" name="OK">
                    <div class="arrow-wrapper">
                    </div>
                    <p class="button-text">OK</p>
                </button>
            </div>
            </div>
        </div>
    </form>
    </body>
</html>
<?php
    if(isset($_POST['OK'])){
        header("Location: ./category.php");
    }
?>