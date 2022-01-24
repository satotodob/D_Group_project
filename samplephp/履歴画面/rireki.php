<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>履歴画面</title>
    <style>
        /*項目を動かさないためにtableをわけたのでカラムの幅を固定にして項目とデータの幅をあわせる
        　項目を動かしたい場合は、tebleを一つにする
        　スクロールはtableをdivで囲む
        */
        .over{
                width: 200px;  /* スクロールの出る場所を決める */
                height: 214px;  /*表の高さを弄らなかった場合の7行分くらい*/
                /*scollだと常に表示*/
                overflow-y: auto;
            }
    </style>
</head>
<body>

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

<header>
    <input type="button" name="manager" value="管理者" onclick="location.href='manager_login.php'">
</header>

<h1>注文履歴</h1>
<?php
$order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0');
// $kakutei_count = $order_sql ->fetchcolumn();
// $kakutei_count = $order_sql ->fetch(PDO::FETCH_ASSOC);
$kakutei_count = $order_sql ->fetch();


//確定の商品があるかどうかで判断
if($kakutei_count != 0){
print "<table border='1'>";

    print('<tr><th>商品</th><th>数量</th><th>金額</th></tr>');

print "</table>";

print "<div class='over'>";
print "<table border='1'>";       
        print('<tr>');
    // 変数を0で定義    
        $order_all = 0;
        $money_all = 0;
    // 確定フラグがtrueで会計フラグがfalseの場合
    //  $order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0');
     while($result = $order_sql->fetch()){
        //レコードで取り出した中からカラムを指定して取り出せる
        // print("オーダーidは「".$result['order_id']."」");
        // print("メニューidは「".$result['menu_id']."」");

        //ここで使うのは[メニューid]と[数量]  ↓変数に入れる
        $mnu_id = $result['menu_id']; //メニューidを変数mnu_idに入れる
        $suuryou = $result['quantity']; //数量を変数suuryouに入れる 
        $order_all += $suuryou ;

    $menu_sql = $dbconnect->db-> query('select * from menu_table where menu_id='.$mnu_id);
    while($result = $menu_sql->fetch()){
        //レコードで取り出した中からカラムを指定して取り出す
        
        print("<td>".$result['menu_name']."</td>");
        print("<td>".$suuryou."</td>");

        //必要な[メニュー名]・[単価]を変数に入れる
        $mnu_name = $result['menu_name']; //メニュー名を変数mnu_nameに入れる
        $tanka = $result['menu_pay'];

        /* 最初のwhile文で取り出した「数量(suuryou)」と
        ここのwhile文で取り出した「単価(tanka)」をかけて
        合計金額を変数　$goukei に入れる　*/
        
        $goukei = $suuryou*$tanka;
        $money_all += $goukei;
        print("<td>".$goukei."円"."</td>"."</tr>");
        }; 
    };

 

print "</table>";
print "</div>";


print "<table border='1'>";


    print("<tr>"."<th>"."合計注文数"."</th>");
    print("<td>".$order_all."点"."</td>"."</tr>"); 

    print("<tr>"."<th>"."合計金額"."</th>");
    print("<td>".$money_all."円"."</td>"."</tr>");


print "</table>";



print "<footer>";
print "<div class='fotter_menu'>";
  print ("<a href='category.php'>"."メニューに戻る"."</a>");
  
  
   if($money_all != 0){ //会計が0円の時は以下の表示をさせない
        //セッションpay_totalに合計金額を保持
       $_SESSION['pay_total'] = $money_all;

       print('<input type="button" name="goto_pay" onclick="location.href=\'pay.php\'" value="お会計に進む">');
   }

} else {

    print "商品が注文されていません";

    print('<input type="button" onclick="location.href=\'category.php\'" value="カテゴリー画面へ">');

}

?>
</footer>
    
</body>
</html>