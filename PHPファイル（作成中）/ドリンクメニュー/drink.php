<!DOCTYPE html>
<html>
    <head>
        <title>ドリンクメニュー</title>
        <meta charset="utf-8">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="drink.css">

    </head>
    <body>
        <?php
            require_once "DB.php";
            $dbconnect = new connect; 
        ?>

        <h1 name="drink">飲み物</h1>

        <div id="main" class="site-width"><!-- メイン画面 -->
            <div class="container-area"><!-- 画像選択 -->
                <div class="drink-area">
                    <div class="drink-form-container">
                        <div id="drink_img">
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
                                    }

                                    print ('<span>');
                                    print ('<img src="'.$image.'" style="width:294px">');
                                    print ('<button type="button" class=drink_img value="'.$image.'" data-toggle="modal" data-target="#'.$menuname.'" style="width:460px; height:197px"></button>');
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
                                                        <input type="hidden" name="order_item" value="<?php print($menuname); ?>">
                                                        <input type="hidden" name="item_price" value=<?php print($m_price); ?>>
                                                        <input type="hidden" name="img_price" value=<?php print($image) ; ?>>
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="button" name="item_qty[]" value=1>
                                                        <label for="qty<?php print($num);?>"></label>
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="button" name="item_qty[]" value=2>
                                                        <label for="qty<?php print($num);?>"></label>
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="button" name="item_qty[]" value=3>
                                                        <label for="qty<?php print($num);?>"></label>
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="button" name="item_qty[]" value=4>
                                                        <label for="qty<?php print($num);?>"></label>
                                                        
                                                        <input id="qty<?php $num= ($num + 1); print($num);?>" type="button" name="item_qty[]" value=5>
                                                        <label for="qty<?php print($num);?>"></label>
                                                    </div>

                                                    <div class="modal-footer">
                                                            <input type="button" class="btn btn-secondary" data-dismiss="modal" style="position:absolute; right:1030px" value="戻る">
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

        <form method="post">

        <div>
            <table border="1">
                <tr>
                    <?php
                        $img = "";
                        $item = "";
                        $m_price = "";
                            
                        if(isset($_POST['img_price']))
                        { //hiddenで設定した画像取得
                            $img = $_POST['img_price'];
                            print ('<th><img src="'.$img.'" style="width:80px; height:50px; "</th>');
                        }
                        if(isset($_POST['order_item']))
                        { //hiddenで設定したアイテム名取得
                            $item = $_POST['order_item'];
                            print ('<th>"'.print $item.'"</th>');
                        }
                        if(isset($_POST['item_price']))
                        { //hiddenで設定したアイテム単価取得
                            $m_price = $_POST['item_price'];
                            //print ('<td>"'.print $m_price.'"</td>');
                        }

                        if(isset($_POST['item_qty']))
                        { //radio buttonで選択した数量取得
                            foreach ($_POST['item_qty'] as $optNum => $option) 
                            {

                            }
                        }


                        // <div id="table">
                        //     <table border="1">
                        //         <tr>
                        //             <th>商品画像</th>    
                        //             <td>商品名</td>
                        //             <td>
                        //                 <select>
                        //                     <option>注文数</option>
                        //                     <option>1</option>
                        //                     <option>2</option>
                        //                     <option>3</option>
                        //                     <option>4</option>
                        //                     <option>5</option>
                        //                 </select>
                        //             </td>
                        //             <td>
                        //                 <input type="button" name="order_list" value="注文取消">
                        //             </td>
                        //         </tr>
                        //     </table>
                        // </div>
                    ?>
                </tr>
            </table>
        </div>

        <input type="button" id="back" name="back" value="戻る" style="position:fixed; top:660px; left:50px">
        <input type="button" id="history" name="history" value="履歴" style="position:fixed; top:660px;">
        <input type="button" id="confirm" name="confirm" value="確定" style="position:fixed; top:660px; right:50px">



            
        </div>
        </form>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>