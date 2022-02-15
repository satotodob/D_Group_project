<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理画面</title>

    <style>
     body{
        text-align: center;
        background-color:#95A5A6;
      }

    </style>

</head>

<?php 
     session_start();
     require_once "db_connect.php";
     $dbconnect = new connect();

     if(!isset($_SESSION['manager'])){//管理者確認未チェック時
        //index.phpに飛ばします
         echo "<script>window.location.href = 'manager_login.php';</script>";
        exit;
     }
?>

<body>
<h1>工事中</h1><br>

<input type="button" value="戻る" onclick="location.href='kanri.php'">

    
</body>
</html>