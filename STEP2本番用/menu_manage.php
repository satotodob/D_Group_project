<!DOCTYPE html>
<html lang="en" >
<head>
  <title>商品管理</title>
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="menu_mng.js"></script>
  <link rel="stylesheet" href="css/menu_manage.css">
  <style>

  </style>
</head>
<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect;

    if(!isset($_SESSION['manager'])){//管理者確認未チェック時
        //index.phpに飛ばします
         echo "<script>window.location.href = 'manager_login.php';</script>";
        exit;
     }
?>

<body>
    <h1>商品管理</h1>
    <form action="" method="POST">
        <input type="submit" id="submit" name="inventory" value="在庫管理へ"><br>
        <input type="submit" id="submit" name="kanri" value="管理者画面へ"><br>
    </form>
    <input type="button" name="imgup" value="商品画像登録" onclick="location.href='img_upld.php'">

    <?php
        if(isset($_POST['inventory'])){
            header("Location: ./inventory.php");
        }          
        if(isset($_POST['kanri'])){
            header("Location: ./kanri.php");
        }
    ?>

    <div class="mydiv">
    <form action="" method="POST">
        <table border="1">
            <tr>
                <th>商品登録：</th>
                <th><input type="text" placeholder="商品名" maxlength="20" name='add_name' required></th>
                <th><input type="number" placeholder="価格" class="pricezone" min=0 max=2000 step=1 name='add_pay' required></th>
                <td>
                    <select name="m_category" required>
                        <option disabled selected value>カテゴリーを選択</option>
                        <option value=0>串物</option>
                        <option value=1>飲み物</option>
                        <option value=2>サイド</option>
                    </select>
                </td>
                <th><input type="submit" value="登録" name="add"></th>
            </tr>
        </table>
    </form>
        <div class="msg">
            <?php
            if(isset($_POST["add"])){
                $add_pay = $add_name = $category = "";
                    if(isset($_POST["add_name"])){ 
                        $add_name = $_POST["add_name"]; 
                    if(isset($_POST["add_pay"])) $add_pay = $_POST["add_pay"]; 
                    if(isset($_POST["m_category"])) $category = $_POST["m_category"];
                                        
                    $name_cnt = $dbconnect->db->query('select count(menu_name) from menu_table where menu_name ="'.$add_name.'"');
                    $name_count = $name_cnt->fetchColumn();
    
                    if($name_count == 0){ //名前の登録が0件だったらインサート
                        $dbconnect->db->query('insert into menu_table (menu_id, menu_name, menu_pay, category) values (NULL,"'.$add_name.'", "'.$add_pay.'", "'.$category.'")');
                        
                        print('「'.$add_name.'」の商品登録が完了しました。');
                    
                    }else{//名前の登録が既にされている場合
                        print('メニュー名「'.$add_name.'」は既に登録されています。</font>');
                    }
                    }           
            }
            ?>
        </div>
    </div>

    <h2>商品一覧</h2>

    <form method="POST" action="">
        <select class="select" name="select">
            <option value="1">選択してください</option>
            <option value="2">串もの</option>
            <option value="3">飲み物</option>
            <option value="4">サイド</option>
        </select>
        <button type="submit" name="send">選択</button><br>
    </form>

    <!----------------------update処理↓------------------------------->
    <?php
        if(isset($_POST['upd'])){//編集ボタンを押したら
            print('<div class="info">');
            $itmno = $_POST['item_no'];
            
            foreach($itmno as $key => $valu){
                foreach($valu as $key => $val){
                    if($key == 'm_id' ){
                        $m_id = $val;
                    }
                    if($key == 'm_name' ){
                        $m_name = $val;
                    }
                    if($key == 'price' ){
                        $price = $val;
                    }
                    if($key == 'category' ){
                        $category = $val;
                    }
                    if($key == 'del_flag' ){
                        $del_flag = $val;
                    }   
                }

                //名前重複チェック
                $name_cnt = $dbconnect->db->query('select count(menu_name) from menu_table where menu_name ="'.$m_name.'" and NOT (menu_id ='.$m_id.')');
                $name_count = $name_cnt->fetchColumn();
    
                    if($name_count == 0){ //名前の登録が0件だったらインサート

                //-----ここから-----------画像フォルダ移動処理----------------
                    //まずは元の情報を取り出す
                    $moto_joho = $dbconnect->db->prepare('select * from menu_table where menu_id = :menuid');
                    $moto_joho->bindValue(':menuid',$m_id,PDO::PARAM_INT);
                    $moto_joho->execute();
    
                    while($motojoho = $moto_joho->fetch()){
                        $moto_category = $motojoho['category'];
                        $moto_delflag = $motojoho['menu_del'];
                     }
    
                    if($moto_category == 0){
                        $moto_category = "mainimg";
                    }elseif($moto_category == 1){
                        $moto_category = "drinkimg";
                    }else{
                        $moto_category = "sideimg";
                    }
    
                    if($category == 0){
                        $new_category = "mainimg";
                    }elseif($category == 1){
                        $new_category = "drinkimg";
                    }else{
                        $new_category = "sideimg";
                    }
    
                    if($moto_delflag == 1 && $del_flag == 0){//削除から再登録した
                        //移動
                        $file = 'del_menuimg/'.$m_id.'.jpg';//ファイルのパス
                        if(file_exists($file)){//ファイルが存在している時だけ
                            rename($file , $new_category.'/'.$m_id.'.jpg');//移動先
                        }else{
                            print('<div>●商品「'.$m_name.'」の画像は登録されていません。<br>
                            メニュー表に載せるには画像登録をしてください。</div>');
                        }
                    }
    
                    if($moto_delflag == 0 && $del_flag == 1){//登録から削除した
                        //移動
                        $file = $moto_category.'/'.$m_id.'.jpg';//ファイルのパス
                        if(file_exists($file)){//ファイルが存在している時だけ
                            rename($file , 'del_menuimg/'.$m_id.'.jpg');//移動先
                        }
                    }
    
                    if($moto_delflag == 0 && $del_flag == 0){//登録のまま
                        //移動
                        $file = $moto_category.'/'.$m_id.'.jpg';//ファイルのパス
                        if(file_exists($file)){//ファイルが存在している時だけ
                            rename($file , $new_category.'/'.$m_id.'.jpg');//移動先
                        }else{
                            print('<div>●商品「'.$m_name.'」の画像は登録されていません。<br>
                            メニュー表に載せるには画像登録をしてください。</div>');
                        }
                    }
    
                    if($moto_delflag == 1 && $del_flag == 1){//削除のまま
                        //移動
                        $file = 'del_menuimg/'.$m_id.'.jpg';//ファイルのパス
                        if(file_exists($file)){//ファイルが存在している時だけ
                            rename($file , 'del_menuimg/'.$m_id.'.jpg');//移動しない
                        }else{
                            print('<div>●商品「'.$m_name.'」の画像は登録されていません。<br>
                            再登録時は画像登録をしてください。</div>');
                        }
                    }
                    //-----ここまで-------updateする前に画像フォルダ移動処理--------------------

                    $menu_update = $dbconnect->db->prepare('update menu_table set menu_name = :m_name, menu_pay = :price ,
                                                        category = :category, menu_del = :del_flag where menu_id = :m_id');
                    $menu_update->bindValue(':m_name',$m_name);
                    $menu_update->bindValue(':price',$price,PDO::PARAM_INT);
                    $menu_update->bindValue(':category',$category,PDO::PARAM_INT);
                    $menu_update->bindValue(':del_flag',$del_flag,PDO::PARAM_INT);
                    $menu_update->bindValue(':m_id',$m_id,PDO::PARAM_INT);
                    $menu_update->execute();

                    $upd_list[] = "[ID:".$m_id." ".$m_name."]";
                }else{
                    $no_upd_name[] = "[ID:".$m_id." ".$m_name."]";
                }
            }

            if(isset($upd_list)){
                foreach($upd_list as $val){
                    print($val.' ');
                }
                print("の編集が実行されました。<br>");
            }  
            
            if(isset($no_upd_name)){
                print('<font color="red">');
                foreach($no_upd_name as $val){
                    print($val.' ');
                }
                print("は既に使われている名前のため、編集できませんでした。</font>");
            }
            print('</div>');
        }
    ?>
<!----------------------update処理ここまで------------------------------->

    <div class="mydiv">編集をかけたい商品に✔を入れてください</div>

    <table border="1">
        <tr class="table-header">
            <th></th>
            <th>商品ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>カテゴリー</th>
            <th>登録/削除</th>
        </tr>
        

    <?php
    $count_roop = 0;
    $stmt = $dbconnect->db->query('select * from menu_table where menu_del = 0');
    $stmt2 = $dbconnect->db->query('select * from menu_table where menu_del = 1');

    if (isset($_POST['send']) && isset($_POST['select'])) {
        switch ($_POST['select']) {                  
            case "1": {
                break;
            }
            case "2": {
                $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 0 and menu_del= 0");
                $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 0 and menu_del= 1");   
                   break;
                }
            case "3": {
                $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 1 and menu_del= 0");
                $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 1 and menu_del= 1");  
                    break;
                }
            case "4": {
                $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 2 and menu_del= 0");
                $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 2 and menu_del= 1");  
                    break;
                }
        }
        
    }
        while($row = $stmt->fetch()){
            $count_roop += 1;
            echo "<tr>";
            echo "<td><input type='checkbox' value='$count_roop' name='item_check'></td>";
            echo "<td>$row[menu_id]</td>";
            echo "<td>$row[menu_name]</td>";
            echo "<td>$row[menu_pay]</td>";
            echo "<td>";
            if($row['category']==0){
                echo "串もの";
            }elseif($row['category']==1){
                echo "飲み物";
            }else{
                echo "サイド";
            }
            echo "</td>";
            
            print('<td>登録中</td>');
            echo "</tr>";
        }
        while($row = $stmt2->fetch()){
            $count_roop += 1;
            echo "<tr>";
            echo "<td><input type='checkbox' value='$count_roop' name='item_check'></td>";
            echo "<td>$row[menu_id]</td>";
            echo "<td>$row[menu_name]</td>";
            echo "<td>$row[menu_pay]</td>";
            echo "<td>";
            if($row['category']==0){
                echo "串もの";
            }elseif($row['category']==1){
                echo "飲み物";
            }else{
                echo "サイド";
            }
            echo "</td>";
            
            print('<td>削除済み</td>');
            echo "</tr>";
        }            
    ?>
    </table>

    <br>

    <!----------------------✔入れて表示する欄↓-------------------------------------------->
        <table border="1" class="re_pre">
        <tr class="table-header"><th width="10%">商品ID</th><th>商品名</th><th width="20%">価格</th><th width="17%">カテゴリ</th><th width="15%">登録状況</th><tr>
        </table>
        
        <form action="" method="POST">
            <?php
                //ループ回数カウント用変数
                $count_roop = 0;

                $stmt = $dbconnect->db->query('select * from menu_table where menu_del = 0');
                $stmt2 = $dbconnect->db->query('select * from menu_table where menu_del = 1');

                if (isset($_POST['send']) && isset($_POST['select'])) {
                    switch ($_POST['select']) {                  
                        case "1": {
                            break;
                        }
                        case "2": {
                            $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 0 and menu_del= 0");
                            $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 0 and menu_del= 1");   
                                break;
                        }
                        case "3": {
                            $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 1 and menu_del= 0");
                            $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 1 and menu_del= 1");  
                                break;
                        }
                        case "4": {
                            $stmt = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 2 and menu_del= 0");
                            $stmt2 = $dbconnect->db->query("SELECT * FROM menu_table WHERE category= 2 and menu_del= 1");  
                                break;
                        }
                    }
                }
                
                while($row = $stmt->fetch()){
                    $count_roop += 1;
                    
                    echo "<div id='divno_$count_roop'>";
                    echo "<table border='1'>";

                    echo "<tr>";
                    echo "<input type='hidden' class='form_$count_roop' 
                    name='item_no[$count_roop][m_id]' value='$row[menu_id]'>";
                    echo "<td align='center' width='10%'>$row[menu_id]</td>";
                    echo "<td align='center'><input type='text' class='form_$count_roop' 
                    name='item_no[$count_roop][m_name]' value='$row[menu_name]' placeholder='商品名' maxlength='20' required></td>";
                    echo "<td align='center' width='20%'>￥<input type='number' min=0  max=2000 step=1 class='form_$count_roop' 
                    name='item_no[$count_roop][price]' value='$row[menu_pay]' placeholder='価格' required></td>";

                    echo "<td align='center' width='17%'>";
                    echo "<select class='form_$count_roop' name='item_no[$count_roop][category]'>";
                    if($row['category']==0){
                        print('<option value=0 selected>串もの</option>');
                        print('<option value=1>飲み物</option>');
                        print('<option value=2>サイド</option>');
                    }elseif($row['category']==1){
                        print('<option value=0>串物</option>');
                        print('<option value=1 selected>飲み物</option>');
                        print('<option value=2>サイド</option>');
                    }else{
                        print('<option value=0>串物</option>');
                        print('<option value=1>飲み物</option>');
                        print('<option value=2  selected>サイド</option>');
                    }
                    echo "</td>";
            
                    echo "<td align='center' width='15%'>";
                    echo "<select class='form_$count_roop' name='item_no[$count_roop][del_flag]'>";
                        print('<option value=0 selected>登録</option>');
                        print('<option value=1>削除</option>');                    
                    echo "</td>";
                    echo "</tr>";

                    echo "</table>";
                    echo "</div>";
                }

                while($row = $stmt2->fetch()){
                    $count_roop += 1;

                    echo "<div id='divno_$count_roop'>";
                    echo "<table border='1' class='edittbl'>";

                    echo "<tr>";
                    echo "<input type='hidden' class='form_$count_roop' 
                    name='item_no[$count_roop][m_id]' value='$row[menu_id]'>";
                    echo "<td align='center' width='10%'>$row[menu_id]</td>";
                    echo "<td align='center'><input type='text' class='form_$count_roop' 
                    name='item_no[$count_roop][m_name]' value='$row[menu_name]' placeholder='商品名' maxlength='20' required></td>";
                    echo "<td align='center' width='20%'>￥<input type='number' step=1 min=0 max=2000 class='form_$count_roop' 
                    name='item_no[$count_roop][price]' value='$row[menu_pay]' placeholder='価格' required></td>";

                    echo "<td align='center' width='17%'>";
                    echo "<select class='form_$count_roop' name='item_no[$count_roop][category]'>";
                    if($row['category']==0){
                        print('<option value=0 selected>串もの</option>');
                        print('<option value=1>飲み物</option>');
                        print('<option value=2>サイド</option>');
                    }elseif($row['category']==1){
                        print('<option value=0>串物</option>');
                        print('<option value=1 selected>飲み物</option>');
                        print('<option value=2>サイド</option>');
                    }else{
                        print('<option value=0>串物</option>');
                        print('<option value=1>飲み物</option>');
                        print('<option value=2  selected>サイド</option>');
                    }
                    echo "</td>";
            
                    echo "<td align='center' width='15%'>";
                    echo "<select class='form_$count_roop' name='item_no[$count_roop][del_flag]'>";
                        print('<option value=0>登録</option>');
                        print('<option value=1  selected>削除</option>');                    
                    echo "</td>";
                    echo "</tr>";

                    echo "</table>";
                    echo "</div>";
                }
            ?>
            <div class="mydiv">
            <input type="submit" name="upd" class="re_pre" value="編集する">
            </div>
            </form>
    <!----------------------↑編集用表示欄-------------------------------------------->
    <br>
<script>
       var countnum = <?php print($count_roop); ?>;
</script>    
    
</body>
</html>
