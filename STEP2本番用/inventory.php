<!DOCTYPE html>
<html>
    <head>
        <title>在庫補充画面</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/inventory.css">
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
        <form method ="post" action="">
            <div class='h2'>
            <h2>在庫管理 </h2>
            </div>

        <div class="row1">
            <select name="order">
                <option>選択してください</option>;
                <option value="default">登録順</option>;
                <option value="high">多い順</option>;
                <option value="low">少ない順</option>;
            </select>
        </div>
        
        <br><br><br>
        <div class="row">
            <input type="submit" name="manage" value="並び変える">
        </div>    

    <?php
    //在庫補充ボタン
    if(isset($_POST['refill'])){
        $hairetu = $_POST['replace'];

        foreach($hairetu as $pkey => $value) {
            foreach($value as $koumoku => $nakami) {
                if($koumoku == "hojusu"){
                    $hoju_su = $nakami; //input type=number
                }
                if($koumoku == "menu_id"){ //hidden
                    $menu_id = $nakami;
                }
            }
            if(!empty($hoju_su)){ //$hoju_suの中身がある時は.!はemptyでは空ではない
                $stmt = $dbconnect ->db->query("update menu_table set inventory = inventory + '$hoju_su' where menu_id = $menu_id");

            }
        }            
    }
  
    //管理者画面ボタン
    if(isset($_POST['kanri'])){
        header("Location:kanri.php");
    }
     //商品管理ボタン
    if(isset($_POST['menu'])){
        header("Location:menu_manage.php");
    }
   
    print "<table border = 1>";
    echo "<tr><th>";
    echo "メニュー名";
    echo "</th><th>";
    echo "在庫数";
    echo "</th><th>";
    echo "補充する数を入力";
    echo "</th></tr>";

    //並び替え
    $stmt = $dbconnect ->db->query('select * from menu_table');
    if(isset($_POST['manage'])){
        if($_POST["order"] == "default"){
           $stmt = $dbconnect -> db->query("select * from menu_table order by menu_id asc");
        } else if ($_POST["order"] == "high"){
            $stmt = $dbconnect ->db->query("select * from menu_table order by inventory desc");
        } else if($_POST["order"] == "low"){
            $stmt = $dbconnect -> db->query("select * from menu_table order by inventory asc");
        } 
    }
   
    $count_num =  0;
    
    while($result = $stmt->fetch()){
        $count_num += 1;

        echo "<tr><td>";
        print($result["menu_name"]);
        echo "</td><td  id = 'count'>";
        print($result["inventory"]);
        echo "</td><td>";
        //在庫補充のための2行
        echo "<input type ='number' name ='replace[$count_num][hojusu]'  value =' ' id='limit' min = '1' max = '100' >";
        //menu_idの呼び出し
        echo "<input type='hidden' name='replace[$count_num][menu_id]' value =$result[0]>";
        echo "</td></tr>";
    }
        echo "</table>";
?>

    <div class='button'>
        <tr>
            <td>
            <input type="submit" name="kanri" value="管理者ホーム">
            </td><td>
            <input type="submit" name="refill" value="  補充する">
            </td><td>
            <input type="submit" name="menu" value="商品管理画面">
            </td>
        </tr>
    </div>
</form>
</html>
</body>