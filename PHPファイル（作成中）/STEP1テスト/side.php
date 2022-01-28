<!DOCTYPE html>
<html>
    <head>
        <title>サイドメニュー</title>
        <meta charset="utf-8">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="category.css">

    </head>
    <body>
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
                foreach ($_POST['item_qty'] as $optNum => $option) 
                {

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

        <h1 name="object">一品・サラダ・お食事</h1>

        <div id="main" class="site-width"><!-- メイン画面 -->
            <div class="container-area"><!-- 画像選択 -->
                <div class="object-area">
                    <div class="object-form-container">
                        <div id="object_img">
                            <?php
                                $images = glob('sideimg\*.jpg');
                                foreach($images as $image)
                                {
                                    $name = $image;
                                    $menuname = mb_substr($name, 8, -4);

                                    $items = $dbconnect->db->query('select * from menu_table where menu_name ="'.$menuname.'"');
                                    while($result = $items->fetch())
                                    {
                                        $m_id = $result['menu_id'];     //番号
                                        $m_price = $result['menu_pay']; //値段
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
                                                        <?php print ('<img src="'.$image.'" style="width:300px; height:auto;">'); ?>
                                                        <input type="hidden" name="order_item" value=<?php print($m_id); ?>>
                                                        <input type="hidden" name="item_price" value=<?php print($m_price); ?>>
                                                        <input type="hidden" name="item_name" value="<?php print($menuname); ?>">
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" name="item_qty[]" value=1 checked="checked">
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

                        $img = "";
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