<!DOCTYPE html>
<html>
    <head>
        <title>ドリンクメニューサンプル
        </title>
        <meta charset="UTF-8">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
        <style>
            body{ text-align: center }

            .itemzone{
                width: 900px;
                overflow: hidden;
                margin: 0 auto;
                position: relative;
            }
            
            .itemzone .itembtn {/*div要素全体をボタンにする設定*/
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
            
            .item_img span{
                width: 300px;
                float: left;
                position: relative;
                border: 1px black solid;
                box-sizing: border-box;
            }
            
            .item_img img{
                width: 294px;
            }

            .modal-body img{/*modal内の画像サイズ変更*/
                width: 40%;
                height: auto;
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

        </style>
    </head>
    
<body>
    <?php include('dbconnect.php'); 
        $dbconnect = new connect();
    ?>  <!-- DB接続読み込み -->

    ここのテーブルは
    <?php
        $ini_import = parse_ini_file("terminal.ini", true);
        $table_no = $ini_import["number"];
        print($table_no."番テーブルです。");
    ?>
    
    <div class="itemzone">
        <div class="item_img">
        
            <?php
                $num = 0;
                $images = glob('image/ドリンクimg/*.jpg');
                foreach($images as $image){
                    $str = $image;
                    $menuname = mb_substr($str, 14, -4); 
                    /* $imageの文字数を先頭から14文字（パスの　image/ドリンクimg/　不要な部分）、
                    末尾の4文字（.jpg）を取ってトリミングしたものを$menunameに代入 
                    切り取り文字数はパスのフォルダ名によって数字が変わる
                    */

                    $items = $dbconnect->db->query('select * from menu_table where menu_name ="'.$menuname.'"');
                    //sqlでメニューテーブルからメニュー名を元にレコード検索したものを↓
                    while($result = $items->fetch()){
                        //レコードで取り出した中からカラムを指定して取り出し↓
                        $menuid = $result['menu_id']; //カラムmenu_id
                        $menu_price = $result['menu_pay'];//カラムmenu_pay
                    }           
            
                    print ('<span>');
                    print ($menuname);
                    print ('<img src="'.$image.'">');
                    print ('<button type="button" class="itembtn" data-toggle="modal" data-target="#'.$menuname.'" data-backdrop="static"></button>');
                    print ('</span>');
            ?>
           
                <!-- ボタンクリック後に表示される画面の内容 -->
                <form method="post" action="">
    
                <?php print('<div class="modal fade" id="'.$menuname.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">')?>    
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="Label_toriseiniku"><?php print($menuname);?><br>単価：<?php print($menu_price.'円');?></h4>
                            </div>
                            <div class="modal-body">
                                <?php print ('<img src="'.$image.'">'); ?>
                                <input type="hidden" name="order_item" value="<?php print($menuname); ?>">
                                <input type="hidden" name="item_price" value=<?php print($menu_price); ?>>
                                
                                <div class="qty-radio">
                                注文数量：
                                <input id="qty<?php $num= ($num + 1); print($num);?>" type="radio" nam[e="item_qty[]" value=1>
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
                                <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                                <button type="submit" class="btn btn-outline-danger">決定</button>
                            </div>
                        </div>
                    </div>
                </div>
    
                </form>
                <!-- ボタンクリック後に表示される画面の内容 -->

            <?php }?>
            
        </div>
    </div>


    
<!--　以下は送信ボタンを押した後に何を選択したか表示するだけのコードですが、
    　応用してorderテーブルにインサートする処理とorderテーブルからselectした注文を一覧で表示する
    　処理を書けばSTEP1は対応できるかと思います
-->
    <div class="post_items">
        <?php
            $item = "";
            $menu_price = "";

            if(isset($_POST['order_item'])){ //hiddenで設定したアイテム名取得
                $item = $_POST['order_item'];
            }
            if(isset($_POST['item_price'])){ //hiddenで設定したアイテム単価取得
                $menu_price = $_POST['item_price'];
            }

            if(isset($_POST['item_qty'])){ //radio buttonで選択した数量取得
                foreach ($_POST['item_qty'] as $optNum => $option) {
                }
                print($table_no."番テーブルで「".$item.$menu_price."円」を「".$option."」個注文しました。");

                $total_price = $menu_price * $option;
                print("金額は「".$total_price."」円です。");
            }
        ?>

    </div>

<br><br><br><br>

<!-- モーダルの設定に必要なscript　bodyの閉じる直前に記載 -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>