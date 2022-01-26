<!DOCTYPE html>
<html>
    <head>
        <title>後に差し替え　ダミーページ</title>
        <meta charset="UTF-8">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
        <style>
            body{
                text-align: center
            }
            .item_box{
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                width: 80%;
                margin: 0 auto;
                padding: 5px;
            }

            .item { /*div要素全体をボタンにする設定*/
                position: relative;
                margin: 15px;
                background-color: #CCCCFF;
                height: 80px;
                width: 300px;
            }

            .item button {/*div要素全体をボタンにする設定*/
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                /* buttonのスタイル削除 */
                background-color: transparent;
                border: none;
                cursor: pointer;
                outline: none;
                padding: 0;
                appearance: none;
            }
            .post_items{
                text-align: center;
                width: 70%;
                margin: 0 auto;
                padding:10px;
            }
            table{
                margin: 0 auto;
                width: 85%;
            }
            .ft{
                margin: 10px;
                display: flex;
                justify-content: space-evenly;
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
<h1>串物</h1>

<?php
$ini_import = parse_ini_file("terminal.ini", true);
$table_no = $ini_import["number"];
?>

<div class="item_box">
<div class="item">
    <h2>鳥精肉</h2>
    鳥精肉　2本　300円<br>
    <button type="button" data-toggle="modal" data-target="#torisei" data-backdrop="static"></button>
</div>

<div class="item">
    <h2>手羽先</h2>
    手羽先　2本　270円<br>
    <button type="button" data-toggle="modal" data-target="#tebasaki" data-backdrop="static"></button>
</div>

<div class="item">
    <h2>ナンコツ</h2>
    ナンコツ　2本　270円<br>
    <button type="button" data-toggle="modal" data-target="#nankotu" data-backdrop="static"></button>
</div>

<div class="item">
    <h2>砂肝</h2>
    砂肝　2本　270円<br>
    <button type="button" data-toggle="modal" data-target="#sunagimo" data-backdrop="static"></button>
</div>

</div>
 
    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="torisei" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_torisei">鳥精肉　300円</h4></h4>
                </div>
                <div class="modal-body">
                    鳥精肉（2本セット）を注文する
                    <input type="hidden" name="order_item" value=1>
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 1
                    <input type="radio" name="item_qty" value=2> 2
                    <input type="radio" name="item_qty" value=3> 3
                    <input type="radio" name="item_qty" value=4> 4
                    <input type="radio" name="item_qty" value=5> 5
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-outline-danger">決定</button>
                </div>
            </div>
        </div>
    </div>
    </form>
 
    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="tebasaki" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_tebasaki">手羽先　270円</h4></h4>
                </div>
                <div class="modal-body">
                    手羽先（2本セット）を注文する
                    <input type="hidden" name="order_item" value=2>
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 1
                    <input type="radio" name="item_qty" value=2> 2
                    <input type="radio" name="item_qty" value=3> 3
                    <input type="radio" name="item_qty" value=4> 4
                    <input type="radio" name="item_qty" value=5> 5
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-outline-danger">決定</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="nankotu" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_nankotu">ナンコツ　270円</h4></h4>
                </div>
                <div class="modal-body">
                    ナンコツ（2本セット）を注文する
                    <input type="hidden" name="order_item" value=3>
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 1
                    <input type="radio" name="item_qty" value=2> 2
                    <input type="radio" name="item_qty" value=3> 3
                    <input type="radio" name="item_qty" value=4> 4
                    <input type="radio" name="item_qty" value=5> 5
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-outline-danger">決定</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="sunagimo" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_sunagimo">砂肝　270円</h4></h4>
                </div>
                <div class="modal-body">
                    砂肝（2本セット）を注文する
                    <input type="hidden" name="order_item" value=4>
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 1
                    <input type="radio" name="item_qty" value=2> 2
                    <input type="radio" name="item_qty" value=3> 3
                    <input type="radio" name="item_qty" value=4> 4
                    <input type="radio" name="item_qty" value=5> 5
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-outline-danger">決定</button>
                </div>
            </div>
        </div>
    </div>
    </form>


<div class="post_items">
<?php
    $item = "";
    $qty = "";

    if(isset($_POST['order_item'])){ //hiddenで設定したアイテムid取得
        $item = $_POST['order_item'];
    }

    if(isset($_POST['item_qty'])){ //radiobuttonで設定したアイテムid取得
        $qty = $_POST['item_qty'];
        
        //インサート処理
        $stmt = $dbconnect->db->prepare('insert into order_table values(null, :terminal_no, :menu_id, :quantity, default, default, default)');
        $stmt->bindValue(':terminal_no',$table_no,PDO::PARAM_INT);
        $stmt->bindValue(':menu_id',$item,PDO::PARAM_INT);
        $stmt->bindValue(':quantity',$qty,PDO::PARAM_INT);
        $stmt->execute();
    }
?>
    <table border="1">
        <tr>
        <th>注文商品名</th><th>数量</th><th>金額</th><th>取消しボタン</th>
        </tr>
            <?php
                //order_tableから注文卓、未確定の条件を指定して抽出　$order[]
                $order_sql = $dbconnect->db->query('select * from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                $stmt = $dbconnect->db->query('select COUNT(*) as cnt from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                $order_count = $stmt ->fetchcolumn();
                
                if($order_count == 0){
                    echo "<tr><td colspan=3>注文はありません。</td></tr>";
                }else{
                    while($order = $order_sql->fetch()){
                        //抽出したmenu_idでmenu_tableからメニュー名と単価を取り出し　$menu_item[]
                        $menus = $dbconnect->db->query('select * from menu_table where menu_id = '.$order['menu_id']);
                        while($menu_item = $menus->fetch()){
                        
                    echo "<tr>";
                    echo "<td>".$menu_item['menu_name']."　￥".$menu_item['menu_pay']."</td>";
                    
                    echo "<td>".$order['quantity']."</td>";

                    $sum_price = $menu_item['menu_pay'] * $order['quantity'];
                    echo "<td>".$sum_price."円</td>";
                    
                    echo "<form method='post' action=''>";
                    echo "<td><button type='submit' name='del_order' value='".$order['order_id']."'>決定</button></td></tr>";
                    echo "</form>";
                            if(isset($_POST['del_order'])){ //注文削除ボタン押した場合 order_tableからorder_idを元に削除                          
                                $del = $dbconnect->db->prepare('delete from order_table where order_id = :id');
                                $del->bindValue(':id',$_POST['del_order'],PDO::PARAM_INT);
                                $del->execute();
                                echo "<script>window.location.href = '';</script>";
                            }
                        }
                    }
                }
                ?>
    </table>
</div>

<form method="post" action="">
    <div class="ft">
    <input type="submit" name="return_btn" value="戻る">
    <input type="submit" name="rireki_btn" value="履歴">
    
    <?php if($order_count != 0){ ?>
    <input type="submit" name="kakutei_btn" value="確定">
    <?php }?>
    
    </div>
</form>

<?php print($table_no."番テーブル");?>

<?php
        if(isset($_POST['return_btn'])){
            echo "<script>window.location.href = 'category.php';</script>";
        }
        if(isset($_POST['rireki_btn'])){
            echo "<script>window.location.href = 'rireki.php';</script>";
        }
        if(isset($_POST['kakutei_btn'])){
            //オーダーテーブルの未確定注文（terminal_id指定）を確定1にupdate
            $kakutei_order = $dbconnect->db->prepare('update order_table set 
                                decition_flag = 1 
                                where terminal_id = :terminal_no');
                                
            $kakutei_order->bindValue(':terminal_no', $table_no, PDO::PARAM_INT);
            $kakutei_order->execute();

            echo "<script>window.location.href = 'kakutei.php';</script>";
        }
    ?>
<!-- モーダルの設定に必要なscript　bodyの閉じる直前に記載 -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>