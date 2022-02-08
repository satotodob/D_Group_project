<!DOCTYPE html>
<html>
    <head>
        <title>ドリンクメニュー</title>
        <meta charset="utf-8">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="category.css">

    </head>
    <body>
        <?php
            session_start();
            require_once "DB.php";
            $dbconnect = new connect; 

            $ini_import = parse_ini_file("terminal.ini", true);
            $table_no = $ini_import["number"];//注文卓番号
        ?>

        <?php
            //読み込みの関係上、ポストされた情報（ＤＢにインサート等変更を加える処理）は先頭で行います

            if(isset($_POST['order_item']))
            { //hiddenで設定したメニューid取得
                $item_id = $_POST['order_item'];
            }

            if(isset($_POST['item_qty'])){ //radio buttonで選択した数量取得
                foreach ($_POST['item_qty'] as $optNum => $option){}
                //$optionが注文数量

                $invent_check = $dbconnect->db-> prepare('select inventory from menu_table where menu_id = :menuid');
                $invent_check->bindValue(':menuid',$item_id ,PDO::PARAM_INT);
                $invent_check->execute();
                $item_inventory = $invent_check->fetchColumn(); //在庫数

                if($item_inventory >= $option)
                {
                    //インサート処理 
                    $stmt = $dbconnect->db->prepare('insert into order_table values(null, :terminal_no, :menu_id, :quantity, default, default, default)');
                    $stmt->bindValue(':terminal_no',$table_no,PDO::PARAM_INT);
                    $stmt->bindValue(':menu_id',$item_id,PDO::PARAM_INT);
                    $stmt->bindValue(':quantity',$option,PDO::PARAM_INT);
                    $stmt->execute();

                    $subtruct_iv = $dbconnect->db->prepare('update menu_table set inventory = inventory-:ord_qty where menu_id = :menu_id;');
                    $subtruct_iv->bindValue(':ord_qty',$option,PDO::PARAM_INT);
                    $subtruct_iv->bindValue(':menu_id',$item_id,PDO::PARAM_INT);
                    $subtruct_iv->execute();
                }
                else
                { //在庫がなければ注文できないアラートを出す
                    print('<script type="text/javascript">
                            alert("申し訳ありません\n「'.$_POST['item_name'].'」の在庫が足りず、「'.$option.'」個の注文ができません。");
                           </script>');
                }
            }

            if(isset($_POST['del_order']))
            { //注文削除ボタン押した場合 order_tableからorder_idを元に削除   
                $del_quantity = $_POST['del_quantity'];
                $del_menuid = $_POST['del_menuid'];

                $del = $dbconnect->db->prepare('delete from order_table where order_id = :id');
                $del->bindValue(':id',$_POST['del_order'],PDO::PARAM_INT);
                $del->execute();

                $subtruct_iv = $dbconnect->db->prepare('update menu_table set inventory = inventory+:ord_qty where menu_id = :menu_id;'); //在庫を注文した分戻す
                $subtruct_iv->bindValue(':ord_qty',$del_quantity,PDO::PARAM_INT);
                $subtruct_iv->bindValue(':menu_id',$del_menuid,PDO::PARAM_INT);
                $subtruct_iv->execute();
            }

            if(isset($_POST['confirm']))
            {   //注文確定ボタンを押した場合
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

        <h1 name="object">飲み物</h1>

        <div id="main" class="site-width"><!-- メイン画面 -->
            <div class="container-area"><!-- 画像選択 -->
                <div class="object-area">
                    <div class="object-form-container">
                        <div id="object_img">
                            <?php
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
                                        $m_invent = $result['inventory']; 
                                    }

                                    print ('<span>');
                                    print ('<img src="'.$image.'" style="width:294px">');
                                    print $m_price.'円';
                                    print ('<button type="button" class=object_img value="'.$image.'" data-toggle="modal" data-target="#'.$menuname.'" style="width:460px; height:197px"></button>');
                                    print ('</span>');?>


                                    <form method="post" action="">
                                        <?php print ('<div class="modal fade" id="'.$menuname.'" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">') ?>
                                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="label1"><?php print $menuname; ?></h5>
                                                        <h5 class="text-danger" id="label2" style="text-align: center">ご注文数を入力してください</h5>
                                                    </div>
                                    
                                                    <div class="modal-body">
                                                        <?php print ('<img src="'.$image.'">'); ?>
                                                        <input type="hidden" name="order_item" value=<?php print($m_id); ?>>
                                                        <input type="hidden" name="item_price" value=<?php print($m_price); ?>>
                                                        <input type="hidden" name="item_name" value="<?php print($menuname); ?>">

                                                        <?php
                                                            if($m_invent == 0)
                                                            {
                                                                print ('<h5 class="text-danger" id="label2" style="text-align: center">売り切れ</h5>');
                                                            }
                                                            else if($m_invent == 1)
                                                            {
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">');
                                                                print ('<label for="qty<?php print($num);?>">1</label>');
                                                            }
                                                            else if($m_invent == 2)
                                                            {
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">');
                                                                print ('<label for="qty<?php print($num);?>">1</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=2>');
                                                                print ('<label for="qty<?php print($num);?>">2</label>');
                                                            }
                                                            else if($m_invent == 3)
                                                            {
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">');
                                                                print ('<label for="qty<?php print($num);?>">1</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=2>');
                                                                print ('<label for="qty<?php print($num);?>">2</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=3>');
                                                                print ('<label for="qty<?php print($num);?>">3</label>');
                                                            }
                                                            else if($m_invent == 4)
                                                            {
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">');
                                                                print ('<label for="qty<?php print($num);?>">1</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=2>');
                                                                print ('<label for="qty<?php print($num);?>">2</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=3>');
                                                                print ('<label for="qty<?php print($num);?>">3</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=4>');
                                                                print ('<label for="qty<?php print($num);?>">4</label>');
                                                            }
                                                            else
                                                            {
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">');
                                                                print ('<label for="qty<?php print($num);?>">1</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=2>');
                                                                print ('<label for="qty<?php print($num);?>">2</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=3>');
                                                                print ('<label for="qty<?php print($num);?>">3</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=4>');
                                                                print ('<label for="qty<?php print($num);?>">4</label>');
                                                                
                                                                print ('<input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=5>');
                                                                print ('<label for="qty<?php print($num);?>">5</label>');
                                                            }
                                                        ?>
                                                    </div>

                                                    <div class="modal-footer">
                                                            <input type="button" class="btn btn-secondary" data-dismiss="modal" value="戻る">
                                                            <input type="submit" class="btn btn-primary" value="確定">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>    
                                    </form>                                
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div>
        <form method="post">
            
            <table border="1">
                <tr>
                    <?php
                        $stmt = $dbconnect->db->query('select COUNT(*) as cnt from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                        $order_count = $stmt ->fetchcolumn();

                        $item = "";
                        $m_price = "";
                        

                        $order_sql = $dbconnect->db->query('select * from order_table where terminal_id = '.$table_no.' and decition_flag = 0');
                        
                        if($order_count == 0)
                        {//未確定注文が0の場合
                            echo "<tr><td colspan=4>注文はありません。</td></tr>";
                        }
                        else
                        {   
                            while($order = $order_sql->fetch())
                            {
                                $menus = $dbconnect->db->query('select * from menu_table where menu_id = '.$order['menu_id']);
                                
                                while($menu_item = $menus->fetch())
                                {
                                    print ('<th><img src="menuimg/'.$menu_item['menu_name'].'.jpg" style="width:75px; height:55px;"></th>');
                                
                                    $item = $menu_item['menu_name'];
                                    print ('<th>'.$item.'</th>');

                                    $m_price = $menu_item['menu_pay'];
                                    print ('<th>'.$m_price * $order['quantity'].'¥</th>');
                            
                                    print ('<th>'.$order['quantity'].'</th>'); 
                                    print ('<form method="post" action="">');
                                    print ('<input type="hidden" name="del_quantity" value="'.$order['quantity'].'">'); //注文数
                                    print ('<input type="hidden" name="del_menuid" value="'.$order['menu_id'].'">');    //メニュー番号
                                    print ('<td><button type="submit" name="del_order" value="'.$order['order_id'].'">注文取消</button></td></tr>');
                                    print ('</form>');  
                                } 
                            }
                        }
                    ?>
            </table>
            <?php if($order_count != 0){?>
            <div class="cnf_btn"><input type="submit" id="confirm" name="confirm" value="確定"></div><?php }?>

        </form>
        </div>

        <div class="ft_btn">
        <input type="button" id="back" name="back" value="戻る" onclick="location.href='category.php'">
        <input type="button" id="history" name="history" value="履歴" onclick="location.href='rireki.php'">
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>