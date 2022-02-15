<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>お会計画面</title>
  <link rel="stylesheet" href="css/pay.css">

</head>
<style>

</style>

<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect();

    $table_no = $_SESSION['table_no'];//注文卓番号
    
    unset($_SESSION['manager']);//管理者認証をはずす
    
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
    <h2>お会計</h2>
    <?php
      //未確定注文がないか件数チェック
      $stmt = $dbconnect->db->query('select count(*) as cnt from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
      $order_count = $stmt ->fetchcolumn();
      $pay_total = 0;
      //注文卓指定　確定済みかつ未払い注文
      $orders = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0 && terminal_id = '.$table_no);
      while($result = $orders->fetch()){
      $menuid = $result['menu_id'];//メニューid
      $ord_qty = $result['quantity'];//数量
        
        //確定済みのメニューの単価ループ
        $menu_info = $dbconnect->db-> query('select menu_pay from menu_table where menu_id = '.$menuid);
        while($menu_price = $menu_info->fetchColumn()){
          $unit_total = $ord_qty * $menu_price;
          $pay_total += $unit_total;
        }
     }
        $tax = floor($pay_total * 0.1);
        $in_tax = $pay_total + $tax;
        if($pay_total != 0){
          print('<h3>現時点の注文金額「￥'.$pay_total.'(+税:'.$tax.')」<br>
            '.$in_tax.'円です。</h3><br>');
        }
      ?>

    <?php if($pay_total == 0){//会計するものがない時 ?>
        ご注文がありません。<br>
        <a href="category.php">メニュー画面</a>より、ご注文ください。<br>
    <?php }else if($order_count != 0 && $pay_total != 0){ ?>
        <!------会計するものがあり、かつ、未確定注文がある場合------->
        未確定の注文があります。<br>
        お会計をする場合、未確定注文はキャンセルされます。<br>
       
    <?php } 
      if($pay_total != 0){//お会計するものがある時
    ?>
     <button onclick="location.href='category.php'">menu画面に戻る</button><br><br>
    <form method="post" action="">
    <input type="submit" name="checkout" value="会計したことにする">
    <?php echo '<input type="hidden" name="total_fee" value='.$pay_total.'></form>';
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

        if($order_count != 0){//未確定注文がある時
          $unconf_order = $dbconnect->db->query('select * from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
          while($unconf = $unconf_order->fetch()){
            $itemid = $unconf['menu_id'];//未確定のメニュー番号
            $itemqty = $unconf['quantity'];//↑の個数
            $ord_id = $unconf['order_id'];//未確定のオーダーid

            //注文削除前に在庫を戻す
            $sum_ivt = $dbconnect->db->query('update menu_table set inventory = inventory +'.$itemqty.' where menu_id = '.$itemid);
            //オーダーを削除する
            $del = $dbconnect->db->query('delete from order_table where order_id ='.$ord_id);
        }
        }

        echo "<script>window.location.href = 'thankyou.php';</script>";
      }
    ?>

    
</body>
</html>