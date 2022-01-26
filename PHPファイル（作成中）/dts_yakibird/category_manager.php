<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者カテゴリ画面</title>

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
<body>
<form action="" method="post">

<?php

// 管理者ページ
if(isset($_POST['manager'])){
    header("Location:manager.html");
}


?>

<header>
    <input type="submit" name="manager" value="管理者">
</header>

<div class="category">
  <a href="users_manage.php">ユーザー情報管理<br>-User-</a>
  <a href="inventory.php">在庫補充管理<br>-Inventory-</a>
  <a href="menu_manage.php">メニュー情報管理<br>-MenuManage-</a>
</div>





</form>
    
</body>
</html>