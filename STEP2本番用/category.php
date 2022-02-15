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
    <input type="submit" name="manager" value="管理者">
</header>

<div class="category">
  <a href="main.php">串もの<br>SPIT-ROASTING FOOD</a>
  <a href="drink.php">飲み物<br>DRINK</a>
  <a href="side.php">サイドメニュー<br>SIDE-MENU</a>
</div>

<footer>
<div class="">
    <input type="submit" name="history" value="履歴">

    <?php
    $order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0 && terminal_id ='. $table_no);
    $kakutei_count = $order_sql ->fetch();
    
    //確定の商品があるかどうかで判断
    if($kakutei_count != 0){
        print('<input type="button" name="goto_pay" onclick="location.href=\'pay.php\'" value="お会計に進む">');
    }?>
</div>
</footer>




</form>
    
</body>
</html>