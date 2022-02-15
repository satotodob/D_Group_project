<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>履歴画面</title>
    <style>
        body{
            background-image: url("./css/image/back.jpg") ;
        }
        h1,.c{
            /*注文がない場合のCSS 中央 */
            text-align    : center;
            font-size     : 40px;
        }
        /*項目を動かさないためにtableをわけたのでカラムの幅を固定にして項目とデータの幅をあわせる
          項目を動かしたい場合は、tebleを一つにする
          スクロールはtableをdivで囲む
        */
        .tbody{
            height        : 340px;
            display       : block;
            overflow-y    : scroll;
        }
        thead{
            width         : 100%;
            display       : block;
            }
        th,td {
            border        : solid 1px;          /* 枠線指定 */
            font-size     : 25px;
            height        : 50px;
            width         : 310px;
        }
        table{
            margin        : auto;
            background-image: url("./css/image/tback2.jpg");
        }
        h1{
            font-size     : 45px
        }
        .fotter_menu{
            margin-top    : 60px;
        }
        .atag{
            font-size     : 15px;
            cursor        : pointer;     /* カーソル   */
            padding       : 10px 10px;   /* 余白       */
            background    : #db8449;   /* 背景色     */
            color         : black;     /* 文字色     */
            line-height   : 1em;         /* 1行の高さ  */
            box-shadow    : 1px 1px #595857;  /* 影の設定 */
            border        : 2px solid #ffffff;    /* 枠の指定 */
            margin-right  : 740px;
        }
        .atag:hover{
            box-shadow    : none;        /* カーソル時の影消去 */
            color         : #595857;   /* 背景色 */
            transform     : scale(1.2);
        }
        [name="goto_pay"]{
            transition    : .3s;         /* なめらか変化 */
            box-shadow    : 2px 2px #666666;  /* 影の設定 */
            border        : 2px solid #ffffff;    /* 枠の指定 */
            cursor        : pointer;     /* カーソル   */
            text-align    : center;
            background-color: #ffffff;
            font-size: 30px;
        }
        [name="goto_pay"]:hover{
            box-shadow    : none;        /* カーソル時の影消去 */
            font-size     : 30px;        /* 文字サイズ */
            transform     : scale(1.1);
        }

        [name="manager"]{
            margin-left   : 95%;
            font-size     : 15pt;        /* 文字サイズ */
            cursor        : pointer;     /* カーソル   */
            padding       : 10px 10px;   /* 余白       */
            background    : #595857;   /* 背景色     */
            color         : white;     /* 文字色     */
            line-height   : 1em;         /* 1行の高さ  */
        }
        .cbut{
            transition    : .3s;         /* なめらか変化 */
            box-shadow    : 2px 2px #666666;  /* 影の設定 */
            border        : 2px solid #ffffff;    /* 枠の指定 */
            cursor        : pointer;     /* カーソル   */
            text-align    : center;
            background-color: #ffffff;
            font-size: 30px;
        }
        .cbut:hover{
            box-shadow    : none;        /* カーソル時の影消去 */
            font-size     : 30px;        /* 文字サイズ */
            transform     : scale(1.1);
        }
    </style>
</head>
<body>

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
?>

<header>
    <input type="button" name="manager" value="管理者" onclick="location.href='manager_login.php'">
</header>

<h1>注文履歴</h1>
<?php
$order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0&& terminal_id = '.$table_no);
$kakutei_count = $order_sql ->fetch();


//確定の商品があるかどうかで判断
if($kakutei_count != 0){
print "<table border='1'>";

//tableをわけないでheadとbodyでわける方法
print "<thead>";
    print('<tr><th>商品</th><th>数量</th><th>金額</th></tr>');
print "</thead>";


print "<tbody class='tbody'>";
        print('<tr>');
    // 変数を0で定義
        $order_all = 0;
        $money_all = 0;
    // 確定フラグがtrueで会計フラグがfalseの場合
    $order_sql = $dbconnect->db-> query('select * from order_table where decition_flag=1 && pay_flag =0 && terminal_id ='. $table_no);
     while($result = $order_sql->fetch()){

        //ここで使うのは[メニューid]と[数量]  ↓変数に入れる
        $mnu_id = $result['menu_id']; //メニューidを変数mnu_idに入れる
        $suuryou = $result['quantity']; //数量を変数suuryouに入れる
        $order_all += $suuryou ;

    $menu_sql = $dbconnect->db-> query('select * from menu_table where menu_id='.$mnu_id);
    while($result = $menu_sql->fetch()){
        //レコードで取り出した中からカラムを指定して取り出す
        print("<td class='w'>".$result['menu_name']."</td>");
        print("<td class='w'>".$suuryou."</td>");

        //必要な[メニュー名]・[単価]を変数に入れる
        $mnu_name = $result['menu_name']; //メニュー名を変数mnu_nameに入れる
        $tanka = $result['menu_pay'];

        /* 最初のwhile文で取り出した「数量(suuryou)」と
        ここのwhile文で取り出した「単価(tanka)」をかけて
        合計金額を変数　$goukei に入れる　*/

        $goukei = $suuryou*$tanka;
        $money_all += $goukei;
        print("<td class='w'>".$goukei."円"."</td>"."</tr>");
        };
    };
print "</tbody>";


print "</table>";


print "<div>";
print "<table border='1'>";


    print("<tr>"."<th>"."合計注文数"."</th>");
    print("<td>".$order_all."点"."</td>"."</tr>");

    print("<tr>"."<th>"."合計金額"."</th>");
    print("<td>".$money_all."円"."</td>"."</tr>");


print "</table>";
print "</div>";



print "<footer>";
print "<div class='fotter_menu'>";
print ("<a href='category.php' class='atag'>"."↶メニューに戻る"."</a>");

   if($money_all != 0){ //会計が0円の時は以下の表示をさせない

    print('<input type="button" name="goto_pay" onclick="location.href=\'pay.php\'" value="お会計に進む">');

   }

} else {

    print "<div class='c'>"."商品が注文されていません"."</div>";

    print('<div class="c"><input type="button" class="cbut" onclick="location.href=\'category.php\'" value="カテゴリー画面へ"></div>');

}

?>
</footer>
</body>
</html>