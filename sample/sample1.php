<!DOCTYPE html>
<html>
    <head>
        <title>テスト画面</title>
        <meta charset="UTF-8">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
        <style>
            .item { /*div要素全体をボタンにする設定*/
                position: relative;
                margin: 15px;
                /* 位置がわかりやすいように設定しています */
                background-color: #CCCCFF;
                height: 200px;
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
        </style>
    </head>
    
<body>
ここのテーブルは

<?php
$ini_import = parse_ini_file("terminal.ini", true);
$table_no = $ini_import["number"];

print($table_no."番テーブルです。");
?>

<div class="item">
    <h2>鳥精肉</h2>
    鳥精肉　300円（2本）<br>
    ※注文は2本単位になります。
    <button type="button" data-toggle="modal" data-target="#toriseiniku" data-backdrop="static"></button>
</div>
 
    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="toriseiniku" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_toriseiniku">鳥精肉　2本　300円</h4></h4>
                </div>
                <div class="modal-body">
                    鳥精肉を注文する
                    <input type="hidden" name="order_item" value="鳥精肉">
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 2本
                    <input type="radio" name="item_qty" value=2> 4本
                    <input type="radio" name="item_qty" value=3> 6本
                    <input type="radio" name="item_qty" value=4> 8本
                    <input type="radio" name="item_qty" value=5> 10本
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


    <div class="item">
    <h2>ビール</h2>
    サッポロクラシック生　390円<br>
    <button type="button" data-toggle="modal" data-target="#sprclassic" data-backdrop="static"></button>
    </div>
 
    <!-- ボタンクリック後に表示される画面の内容 -->
    <form method="post" action="">
    <div class="modal fade" id="sprclassic" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="Label_sprclassic">サッポロクラシック生　390円</h4></h4>
                </div>
                <div class="modal-body">
                    サッポロクラシック生を注文する
                    <input type="hidden" name="order_item" value="サッポロクラシック生">
                    <div>
                    <input type="radio" name="item_qty" value=1 checked> 1杯
                    <input type="radio" name="item_qty" value=2> 2杯
                    <input type="radio" name="item_qty" value=3> 3杯
                    <input type="radio" name="item_qty" value=4> 4杯
                    <input type="radio" name="item_qty" value=5> 5杯
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

    if(isset($_POST['order_item'])){ //hiddenで設定したアイテム名取得
        $item = $_POST['order_item'];
    }

    if(isset($_POST['item_qty'])){ //hiddenで設定したアイテム名取得
        $qty = $_POST['item_qty'];
    }

    if(empty($item)){ //$itemの中身が空(empty)の時
        print($table_no."番テーブルで注文はされていません。");
    }else{
        print($table_no."番テーブルで「".$item."」を「".$qty."」注文しました。");
    }
    

?>

</div>
    
<!-- モーダルの設定に必要なscript　bodyの閉じる直前に記載 -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>