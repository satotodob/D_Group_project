<!DOCTYPE html>
<html>
    <head>
        <title>ドリンクメニュー（仮）</title>
        <meta charset="utf-8">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

         <style>
            body{ text-align: center }

            table{ margin-left: auto;
                   margin-right: auto; }
            
            .container-area{
                width: 1050px;
                overflow: hidden;
                margin: 0 auto;
                position: relative;
            }

            .container-area .itembtn {/*div要素全体をボタンにする設定*/
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

            .drink_img span{
                width: 350px;
                float: left;
                position: relative;
                border: 1px black solid;
                box-sizing: border-box;
            }

            .drink_img img{
                width: 294px;
            }

            .qty-radio input[type="radio"] {/*modal内のradioボタンをボタン風にする設定*/
                display:none;
            }
            
            .qty-radio label {/*modal内のradioボタンをボタン風にする設定*/
                display:inline-block;
                color:#fff;
                background-color:#c6c6ed;
                padding:5px 10px;
                margin: 5px;
                border-radius: 30px;
                
            }
            
            .qty-radio input[type="radio"]:checked + label {/*modal内のradioボタン選択時の設定*/
                background-color:#4169e1;
            }
            
            .modoru{
                width:100%;
                display: flex;
                align-items: flex-start;
            }
            .order_list{
                margin:20px 0px;
            }

            [id ="confirm"]{
                margin:5px;
            }
            
         </style>

    </head>

        <?php
            session_start();
            require_once "db_connect.php";
            $dbconnect = new connect;

            unset($_SESSION['manager']);//管理者認証をはずす
            
            if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
                //index.phpに飛ばします
                echo "<script>window.location.href = 'index.php';</script>";
                exit;
            }
                        
            $table_no = $_SESSION['table_no'];//注文卓番号
        ?>
        <?php
        //読み込みの関係上、ポストされた情報（ＤＢにインサート等変更を加える処理）は先頭で行います
                                    
        if(isset($_POST['order_item']))
        { //hiddenで設定したメニューid取得
            $item_id = $_POST['order_item'];
        }

        if(isset($_POST['item_qty'])){ //radio buttonで選択した数量取得
            foreach ($_POST['item_qty'] as $optNum => $option) {
            }
            //$optionが注文数量

            //インサート処理 
            $stmt = $dbconnect->db->prepare('insert into order_table values(null, :terminal_no, :menu_id, :quantity, default, default, default)');
            $stmt->bindValue(':terminal_no',$table_no,PDO::PARAM_INT);
            $stmt->bindValue(':menu_id',$item_id,PDO::PARAM_INT);
            $stmt->bindValue(':quantity',$option,PDO::PARAM_INT);
            $stmt->execute();
        }

        if(isset($_POST['del_order'])){ //注文削除ボタン押した場合 order_tableからorder_idを元に削除                          
            $del = $dbconnect->db->prepare('delete from order_table where order_id = :id');
            $del->bindValue(':id',$_POST['del_order'],PDO::PARAM_INT);
            $del->execute();
        }

        if(isset($_POST['confirm'])){ //注文確定ボタンを押した場合　
            //form actionをkakutei.phpにして、この処理もkakutei.phpに書いた方が良い気もするけど・・・
            
            //オーダーテーブルの未確定注文（terminal_id指定）を確定1にupdate
            $kakutei_order = $dbconnect->db->prepare('update order_table set 
                                decition_flag = 1 
                                where terminal_id = :terminal_no');
                                
            $kakutei_order->bindValue(':terminal_no', $table_no, PDO::PARAM_INT);
            $kakutei_order->execute();
            //kakutei.phpに飛ばす↓
            echo "<script>window.location.href = 'kakutei.php';</script>";
            exit;
        }
        ?>

    <body>
        
        <h1 name="drink">飲み物</h1>

        <div class="container-area">
            <div class="drink_img">
                
                <?php
                    $num = 0;//ラジオボタンのラベルで使うidの$numはループ前に宣言しておく
                    $images = glob('drinkimg\*.jpg');
                        foreach($images as $image)
                        {
                            $name = $image;
                            $menuname = mb_substr($name, 9, -4);

                            $items = $dbconnect->db->query('select * from menu_table where menu_name ="'.$menuname.'"');
                            while($result = $items->fetch())
                            {
                                $m_id = $result['menu_id'];     //番号
                                $m_price = $result['menu_pay']; //値段
                            }

                        print ('<span>');
                        print ('<img src="'.$image.'">');
                        print ('<button type="button" class="itembtn" value="'.$image.'" data-toggle="modal" data-target="#'.$menuname.'"></button>');
                        print ('</span>');
                ?>


                <form method="post" action="">
                    <?php
                        print ('<div class="modal fade" id="'.$menuname.'" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">') ?>
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="label1"><?php print $menuname."  ".$m_price; ?>円</h5>
                                        <h5 class="text-danger" id="label2" style="text-align: center">ご注文数を入力してください</h5>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <?php print ('<img src="'.$image.'">'); ?>
                                        <input type="hidden" name="order_item" value="<?php print($m_id); ?>">

                                        <div class="qty-radio">
                                            <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1>
                                            <label for="qty<?php print($num);?>">1</label>
                                                        
                                            <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=2>
                                            <label for="qty<?php print($num);?>">2</label>
                                                        
                                            <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=3>
                                            <label for="qty<?php print($num);?>">3</label>
                                                        
                                            <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=4>
                                            <label for="qty<?php print($num);?>">4</label>
                                                        
                                            <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=5>
                                            <label for="qty<?php print($num);?>">5</label>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <div class="modoru"><div><input type="button" id="modoru" class="btn btn-secondary" data-dismiss="modal" value="戻る"></div></div>
                                        <input type="submit" class="btn btn-primary" value="確定">
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                        <?php } ?>
                        
            </div>
        </div>
    <!-----------------------------　注文後の表示ゾーン↓　--------------------------------->
    <div class="order_list">

        <form method="post">
            <table border="1">
                <tr>
                <th>注文商品イメージ</th><th>商品名</th><th>注文数</th><th>注文取り消し</th>
                </tr>
                <tr>
                <?php
                    //注文卓、未確定の条件を指定した注文数のカウント
                    $stmt = $dbconnect->db->query('select COUNT(*) as cnt from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                    $order_count = $stmt ->fetchcolumn();

                    //★注文卓、未確定の条件を指定してorder_tableから抽出
                    $order_sql = $dbconnect->db->query('select * from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                    
                
                        if($order_count == 0){//未確定注文が0の場合
                            echo "<tr><td colspan=4>注文はありません。</td></tr>";
                        }else{
                            while($order = $order_sql->fetch()){//★の配列を回す orderテーブルの情報は$order[カラム]で取り出せる
                                //menu_idを取り出し、さらに検索に使う
                                $menus = $dbconnect->db->query('select * from menu_table where menu_id = '.$order['menu_id']);
                                while($menu_item = $menus->fetch()){//抽出したmenu_idでmenu_tableからメニュー名と単価を取り出す
                                                                    //メニューテーブルの情報は$menu_item[カラム]で取り出せる
                        
                                print('<tr>'); //imageを名前でimgフォルダから指定
                                print('<td><img src="menuimg/'.$menu_item['menu_name'].'.jpg" style="width:80px; height:50px;"></td>');
                                
                                print('<td>'.$menu_item['menu_name'].'  '.$menu_item['menu_pay'].'円</td>'); //メニュー名　余白単価
                               
                                print('<td>'.$order['quantity'].'</td>'); //数量
                                
                                print('<form method="post" action="">');
                                print('<td><button type="submit" name="del_order" value="'.$order['order_id'].'">注文取り消し</button></td></tr>');
                                print('</form>');
                                }
                            }
                        }
                ?>
                </tr>
            </table>
            
            <?php if($order_count != 0){?>
            <input type="submit" id="confirm" name="confirm" value="確定"><?php }?>
        </form>
        
    </div>        
        
        
        <button type="button" class="button" name="back" onclick="location.href='category.php'">戻る</button>
        <button type="button" class="button" name="history" onclick="location.href='rireki.php'">履歴</button>
        


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>