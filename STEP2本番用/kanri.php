<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者メニュー画面</title>

    <link rel="stylesheet" href="css/kanri.css">

    <style>

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

     // ホーム画面へ
     if(isset($_POST['home'])){
        header("Location:home.php");
     }

     if(isset($_POST['logout'])){
        unset($_SESSION['user_name']);
        unset($_SESSION['pass']);
        unset($_SESSION['manager']);
        $_SESSION = array();
        setcookie(session_name(), '', time()-1, '/');
        session_destroy();

        header("Location:index.php");
     }
?>

<body>
<form action="" method="post">

<header>
    <input type="submit" name="logout" value="ログアウト">
    <input type="submit" name="home" value="ホーム画面へ">
</header>

<div class="category">
  <a href="users_manage.php">ユーザー情報管理<br>-User-</a>
  <a href="inventory.php">在庫補充管理<br>-Inventory-</a>
  <a href="menu_manage.php">メニュー情報管理<br>-MenuManage-</a>
</div>

</form>
    
</body>
</html>