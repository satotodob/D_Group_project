<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <style>
        body{
        background-color :#c0c0c0;
        }
        h1,h2{
            text-align: center;
        }
        table{
            margin-left: auto;
            margin-right: auto;
        }
        .table-header {
            background-color: #95A5A6;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        select{
            position: relative;
            display: flex;
            width: 20em;
            height: 3em;
            line-height: 3;
            margin-left: auto;
            margin-right: auto;        
        }
        button{
            position: relative;
            display: flex;
            margin-left: auto;
            margin-right: auto;
        }
        #submit{
            height: 50px;
            width: 100px;
            text-align: center;
        }
        .mydiv{
            text-align: center;
        }

  </style>
</head>
<body>
    <h1>商品管理</h1>
    <form action="" method="POST"> 
        <input type="submit" id="submit" name="inventory" value="在庫管理へ"><br>
        <input type="submit" id="submit" name="kanri" value="管理者画面へ"><br>
    <div class="mydiv">
        商品登録：
        <input type="text" placeholder="商品名" name='add_name'>
        <input type="number" placeholder="価格" name='add_pay'>
        <input type="number" placeholder="カテゴリー"  name='category'>
        <input type="submit" value="登録" name="add"><br>
        <!-- 商品消除：
        <input type="text" placeholder="商品名" name='menu_name'>
        <input type="submit" value="消除" name ="del" Onclick="return ConfirmDelete()"><br> -->
    </div>
    <h2>商品一覧</h2>
    
    <table border="1">
        <tr class="table-header">
            <th></th>
            <th>商品ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>カテゴリー</th>
        </tr>
    <select class="select" name="select">
        <option value="1">選択してください</option>
        <option value="2">串もの</option>
        <option value="3">飲み物</option>
        <option value="4">サイド</option>
    </select>
    <button name="send">選択</button><br>
    <?php
        if(isset($_POST['inventory'])){
            header("Location: ./inventory.php");
        }          
        if(isset($_POST['kanri'])){
            header("Location: ./kanri.php");
        }

    $db = new PDO('mysql:host=localhost;dbname=yakibird;charset=utf8','root','admin');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    $stmt = $db -> query('select * from menu_table');
    $send = $select = "";
    if (isset($_POST['send']) && isset($_POST['select'])) {
        switch ($_POST['select']) {                  
            case "1": {
                break;
            }
            case "2": {
                $stmt = $db->prepare("SELECT * FROM menu_table WHERE menu_id <33 ");   
                   break;
                }
            case "3": {
                $stmt = $db->prepare("SELECT * FROM menu_table WHERE menu_id >33 and menu_id <38 ");   
                    break;
                }
            case "4": {
                $stmt = $db->prepare("SELECT * FROM menu_table WHERE menu_id >39");   
                    break;
                }
        }
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ( $stmt->fetchAll() as $row) {
            echo "<tr>";
            echo "<td><input type='number' value ='$row[menu_id]'></td>";
            echo "<td><input type='text' value ='$row[menu_name]'></td>";
            echo "<td><input type ='text' value='$row[menu_pay]'></td>";
            echo "<td><input type ='text' value='$row[category]'</td>";
            echo "</tr>";            
        }
    }
        
    if(isset($_POST["add"])){
        $add_pay = $add_name = $category = "";
            if(isset($_POST["add_name"])){ 
                $add_name = $_POST["add_name"]; 
            if(isset($_POST["add_pay"])) $add_pay = $_POST["add_pay"]; 
            if(isset($_POST["category"])) $category = $_POST["category"];                  
            $db->query('insert into menu_table (menu_id, menu_name, menu_pay, category) values (NULL,"'.$add_name.'", "'.$add_pay.'", "'.$category.'")');
            }           
            header("Location: ./menu_manage.php");
    }
    
    if(isset($_POST["del"])){
        if(isset($_POST["id"])){
            $menu_id = $_POST["id"];                  
            $db->query('update menu_table set category = "1" where menu_table.menu_id ='.$menu_id);     
        }
        header("Location: ./menu_manage.php");
    }

    if(isset($_POST["upd"])){
        $id = $name =  $gia= $category ="";
        if(isset($_POST["id"])){
            $id = $_POST["id"];
            if(isset($_POST["name"])) $name = $_POST["name"][$id];
            if(isset($_POST["gia"])) $gia = $_POST["gia"][$id];
            if(isset($_POST["category"])) $category = $_POST["category"][$id];
            $db->query('update menu_table set menu_name = "'.$name.'", menu_pay="'.$gia.'", category="'.$category.'" where menu_id ='.$id);
        }
        header("Location: ./menu_manage.php");
    }

    while($data = $stmt->fetch(PDO::FETCH_NUM)){
        echo "<tr>";
        echo "<td><input type='checkbox' value ='$data[0]' name='id'></td>";
        echo "<td>$data[0]</td>";
        echo "<td><input type='text' value ='$data[1]' name='name[$data[0]]'></td>";
        echo "<td><input type ='text' value='$data[2]' name='gia[$data[0]]'></td>";
        echo "<td><input type ='text' value='$data[5]' name='category[$data[0]]'</td>";
        echo "</tr>";
    }
    ?>
    <!-- <script>
        function ConfirmDelete(){
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }
    </script> -->
    </table>
    <input type="submit" value="消除" name ="del"><br>
    <input type="submit" value="編集" name ="upd"><br>

    </form>
</body>
</html>
