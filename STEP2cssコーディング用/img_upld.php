<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>メニュー画像アップロード</title>
  <style>
      body{
          text-align:center;
      }
      div{
          margin:15px 0px;
      }
      .cate_choice input[type="radio"]{
            display:none;
      }

      .cate_choice label{
            display:inline-block;
            color:#fff;
            background-color:#8e8e9b;
            padding:5px 10px;
            margin: 5px;
            border-radius: 20px;
      }

      .cate_choice input[type="radio"]:checked + label{
            background-color:#f35886;
      }
  </style>

</head>

<?php            
        session_start();
        require_once "db_connect.php";
        $dbconnect = new connect();
        
?>


<body>
    <form method="POST" action="" enctype="multipart/form-data">
        
        <h2>商品画像登録</h2>

        <div>
            登録する画像を選択してください<br>
            <input type="file" name="imgf_data">
        </div>
        <div>
            登録するメニュー名を入力してください<br>
            <input type ="text" name="menuname" value="" required>
        </div>
        <div class="cate_choice">
            登録する画像のカテゴリーを選択してください<br>
            <input id="kusi" type="radio" name="category" value="main" checked="checked">
            <label for="kusi">串物</label>

            <input id="drk" type="radio" name="category" value="drink">
            <label for="drk">ドリンクメニュー</label>

            <input id="side" type="radio" name="category" value="side">
            <label for="side">サイドメニュー</label>

        </div>
        <div class="">
            <input type ="submit" name="go_imgup" value="画像をアップロードする">
        </div>

        <div>
            <?php
                if(isset($_POST['go_imgup'])){//画像アップボタンを押したら

                    if(!empty($_FILES['imgf_data']['name'])){//ファイル名がある時

                        $menu_name = $_POST['menuname']; //textboxで入力されたメニュー名

                        $chec_jpg = substr($_FILES['imgf_data']['name'],-4);//拡張子の取り出し                        
                        
                        if($chec_jpg != ".jpg"){//拡張子で分岐
                            print('.jpg拡張子の画像ファイルのみアップロードできます。');

                        }else{//jpg拡張子だったら

                            //menu_nameでDBメニューtableの登録件数チェック
                            $name_cnt = $dbconnect->db->query('select count(menu_name) from menu_table where menu_name = "'.$menu_name.'"');
                            $name_count = $name_cnt->fetchColumn();

                            if($name_count==0){//DBのメニューtableに登録なし
                            print('メニューに登録されている画像ファイルのみアップロードできます。<br>メニュー登録を確認してください。<br>');
                        
                            }else{//登録のあるメニュー名での画像ファイルだった場合

                                //登録していようとしている画像は削除済み商品ではないかチェック
                                $del_check = $dbconnect->db->query('select menu_del from menu_table where menu_name = "'.$menu_name.'"');
                                $del_ck = $del_check->fetchColumn();

                                if($del_ck==1){//DB登録はあるが、削除済みメニューの場合
                                    print($menu_name.'は削除済みメニューのようです。
                                    <br>画像登録する場合は、商品を登録状態にしてください。<br>');

                                }else{//DB登録中メニューの場合
                                    //選択しているカテゴリが正しいカテゴリか登録先チェック
                                    $cate_check = $dbconnect->db->query('select category from menu_table where menu_name = "'.$menu_name.'"');
                                    $ctgry_ck = $cate_check->fetchColumn();
                                    //0串物　1ドリンク 2サイド

                                    //menu_idの取り出し
                                    $menuid_check = $dbconnect->db->query('select menu_id from menu_table where menu_name = "'.$menu_name.'"');
                                    $m_id_ck = $menuid_check->fetchColumn();

                                    if($_POST['category'] == "main"){//カテゴリーメインを選択した場合
                                        if($ctgry_ck == 0){//ラジオボタンで選択したカテゴリとDB上のカテゴリ一致
                                            //既に同じ名前の画像が存在していないかチェック
                                            $registerd_img = 'mainimg/'.$m_id_ck.'.jpg';//調べるディレクトリのパス 

                                            if (file_exists($registerd_img)) {//既にその画像はある
                                            print('すでにこの画像は登録されています<br>');
                                            }else{
                                                //画像登録されていない時だけ登録する
                                                $save_place = 'mainimg/'. $m_id_ck.'.jpg';//カテゴリ別フォルダ　保存先確保
                                                move_uploaded_file($_FILES['imgf_data']['tmp_name'], $save_place);
                                        
                                                //全メニューフォルダへもコピー保存
                                                copy('mainimg/'.$m_id_ck.'.jpg', 'menuimg/'.$m_id_ck.'.jpg');
                                            
                                                print($menu_name.'のメニュー画像登録が完了しました！<br>');
                                            }
                                        }else{
                                            print('選択したカテゴリーが異なるようです。'.$menu_name.'の登録カテゴリーを確認してください。');
                                        }

                                    }elseif($_POST['category'] == "drink"){//カテゴリードリンク
                                        if($ctgry_ck == 1){//ラジオボタンで選択したカテゴリとDB上のカテゴリ一致
                                            //既に同じ名前の画像が存在していないかチェック
                                            $registerd_img = 'drinkimg/'.$m_id_ck.'.jpg';//調べるディレクトリのパス 

                                            if (file_exists($registerd_img)) {//既にその画像はある
                                            print('すでにこの画像は登録されています<br>');
                                            }else{
                                                //画像登録されていない時だけ登録する
                                                $save_place = 'drinkimg/'. $m_id_ck.'.jpg';//カテゴリ別フォルダ　保存先確保
                                                move_uploaded_file($_FILES['imgf_data']['tmp_name'], $save_place);
                                        
                                                //全メニューフォルダへもコピー保存
                                                copy('drinkimg/'.$m_id_ck.'.jpg', 'menuimg/'.$m_id_ck.'.jpg');
                                            
                                                print($menu_name.'のメニュー画像登録が完了しました！<br>');
                                            }
                                        }else{
                                            print('選択したカテゴリーが異なるようです。'.$menu_name.'の登録カテゴリーを確認してください。');
                                        }

                                    }else{//カテゴリーサイド
                                        if($ctgry_ck == 2){//ラジオボタンで選択したカテゴリとDB上のカテゴリ一致
                                            //既に同じ名前の画像が存在していないかチェック
                                            $registerd_img = 'sideimg/'.$m_id_ck.'.jpg';//調べるディレクトリのパス 

                                            if (file_exists($registerd_img)) {//既にその画像はある
                                            print('すでにこの画像は登録されています<br>');
                                            }else{
                                                //画像登録されていない時だけ登録する
                                                $save_place = 'sideimg/'. $m_id_ck.'.jpg';//カテゴリ別フォルダ　保存先確保
                                                move_uploaded_file($_FILES['imgf_data']['tmp_name'], $save_place);
                                        
                                                //全メニューフォルダへもコピー保存
                                                copy('sideimg/'.$m_id_ck.'.jpg', 'menuimg/'.$m_id_ck.'.jpg');
                                            
                                                print($menu_name.'のメニュー画像登録が完了しました！<br>');
                                            }
                                        }else{
                                            print('選択したカテゴリーが異なるようです。'.$menu_name.'の登録カテゴリーを確認してください。');
                                        }
                                    }
                                }
                            }
                        }
                        

                    }else{
                        print('画像のアップロードができていません。<br>');
                    }
                }
            ?>
        </div>

    </form>

    <div>
        <input type="button" name="back" value="管理者メニューに戻る" onclick="location.href='kanri.php'">
    </div>

</body>
</html>