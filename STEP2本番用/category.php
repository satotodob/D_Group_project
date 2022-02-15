<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カテゴリ画面</title>

    <link rel="stylesheet" href="css/category.css">

    <style>
    </style>

</head>
<body>
<form action="" method="post">

<?php
session_start();
require_once "db_connect.php";
$dbconnect = new connect();

unset($_SESSION['manager']);//管理者認証をはずす

$table_no = $_SESSION['table_no'];//注文卓番号

if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
    //index.phpに飛ばします
     echo "<script>window.location.href = 'index.php';</script>";
    exit;
}

// お会計ページ
if(isset($_POST['history'])){
    header("Location:rireki.php");
}
// 管理者ページ
if(isset($_POST['manager'])){
    header("Location:manager_login.php");
}
?>

<header>
    <p><img class="img" src="./categories/images.png">
    <input type="submit" name="manager" value="管理者"></p>
    <p class="moji">こちらから注文ができます！<br>画面をクリックしてメニューをお選びください。</p>
</header>
<hr>

<div class="box">
  <a href="main.php" class="main">串もの<br>SKEWER-GRILLED</a>
  <a href="drink.php" class="drink">飲み物<br>DRINK</a>
  <a href="side.php" class="side">サイドメニュー<br>SIDE-MENU</a>
</div>

<h2>全て税抜き価格となっております</h2>

<footer>
    <input type="submit" name="history" value="履歴">

    <?php
    $order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0 && terminal_id ='. $table_no);
    $kakutei_count = $order_sql ->fetch();

    //確定の商品があるかどうかで判断
    if($kakutei_count != 0){
        print('<input type="button" name="goto_pay" onclick="location.href=\'pay.php\'" value="お会計に進む">');
    }?>
</footer>




</form>
</body>
</html>