<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カテゴリ画面</title>

    <style>
        body*{
            position: fixed;
        }
        header{
            width: 100%;
            text-align: right;
            float: right;
            margin: 20px;
        }
        footer{
            width: 100%;
            padding: 30px 0;

            
        }
        .category a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 0 auto;
            padding: 1em 2em;
            width: 300px;
            color: #333;
            font-size: 18px;
            font-weight: 700;
            background-color: #ccc;
            border-radius: 50vh;
            transition: 0.3s;
            }

        .category a::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            width: calc(100% - 4px);
            height: calc(100% - 4px);
            border: 2px solid #3d9ec8;
            border-radius: 50vh;
            transition: 0.2s;
        }

        .category a::after {
            content: '';
            width: 5px;
            height: 5px;
            border-top: 3px solid #333333;
            border-right: 3px solid #333333;
            transform: rotate(45deg);
        }

        .category a:hover::before {
            top: 0;
            left: 0;
        }

        .category a:hover {
            text-decoration: none;
            background-color: #a0c4d3;
        }
    </style>

</head>

<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect();
    
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
<form action="" method="post">

<?php

// 履歴ページ
if(isset($_POST['history'])){
    header("Location:rireki.php");
}
// お会計ページ
if(isset($_POST['pay'])){
    header("Location:pay.php");
}

?>

<header>
    <input type="button" name="manager" value="管理者" onclick="location.href='manager_login.php'">
</header>

<div class="category">
  <a href="main.php">串もの<br>SPIT-ROASTING FOOD</a>
  <a href="drink.php">飲み物<br>DRINK</a>
  <a href="side.php">サイドメニュー<br>SIDE-MENU</a>
</div>

<footer>
<div class="">
    <input type="submit" name="history" value="履歴">
    <input type="submit" name="pay" value="お会計">
</div>
</footer>

</form>
    
</body>
</html>