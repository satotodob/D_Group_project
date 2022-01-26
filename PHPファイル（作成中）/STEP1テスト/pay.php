<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>お会計画面ダミー</title>

</head>

<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect();

    $ini_import = parse_ini_file("terminal.ini", true);
    $table_no = $ini_import["number"];
    
    unset($_SESSION['manager']);//管理者認証をはずす
    
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
    <h2>お会計ダミーページ</h2>
    
    <?php 
      //確定済み注文を支払いする
      if(isset($_SESSION['pay_total'])){//合計金額がセッションにあれば
        $totalfee = $_SESSION['pay_total'];
        $zei = floor($totalfee * 0.1);
        $zeikomi = $totalfee + $zei;
        echo '合計お支払い金額は「'.$totalfee.'」円 ＋（'.$zei.'）税';
        echo '<br>￥'.$zeikomi.'（税込み）';
        
      ?>

    <form method="post" action="">
    <input type="submit" name="checkout" value="会計したことにする">
    <?php echo '<input type="hidden" name="total_fee" value='.$totalfee.'></form>';
     }
    ?>
  
    <?php 
      if(isset($_POST['checkout'])){//会計したことにするボタン押したら
      date_default_timezone_set('Asia/Tokyo');//日本時間設定
      $genzai = date('Y-m-d H:i:s');
      $total_fee = $_POST['total_fee'];
        //会計インサート処理
        $stmt = $dbconnect->db->prepare('insert into payment_table values(default, :total_fee, :genzai)');
        $stmt->bindValue(':total_fee',$total_fee,PDO::PARAM_INT);
        $stmt->bindValue(':genzai',$genzai);
        $stmt->execute();
        $last_id = $dbconnect->db->lastInsertId();
        
        //オーダーテーブルの確定済み注文（terminal_id指定）の支払い済みpay_flag=1 ,payment_id= $last_idにupdate
        $kakutei_order = $dbconnect->db->prepare('update order_table set 
                            pay_flag = 1 ,
                            payment_id = :lastid 
                            where terminal_id = :terminal_no 
                            and decition_flag = 1');
                            
        $kakutei_order->bindValue(':lastid', $last_id, PDO::PARAM_INT);
        $kakutei_order->bindValue(':terminal_no', $table_no, PDO::PARAM_INT);
        $kakutei_order->execute();

        //セッションの情報を削除
        unset($_SESSION['pay_total']);//session 'pay_total'を削除 unset

        echo "<script>window.location.href = 'category.php';</script>";
      }
    ?>

    <button onclick="location.href='category.php'">menu画面に戻る</button>
</body>
</html>