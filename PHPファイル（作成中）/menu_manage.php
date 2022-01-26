<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
</head>
<body>
    <h1>商品管理</h1>
    <h2>商品一覧</h2>

    <form action="" method="POST">
    <button type="submit" name="inventory">
      <p>在庫管理へ</p>
    </button>
    <button type="submit" name="kanri">
      <p>管理者画面へ</p>
    </button>

    <table border="1">
        <tr>
            <th>商品ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>カテゴリー</th>
        </tr>

    <?php
        if(isset($_POST['inventory'])){
            header("Location: ./inventory.php");
        }          
        if(isset($_POST['kanri'])){
            header("Location: ./kanri.php");
        }

    $db = new PDO('mysql:host=localhost;dbname=yakibird;charset=utf8','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    $stmt = $db -> query('select * from menu_table');

    if(isset($_POST["send"])){
        $id =$pay = $name = $category = "";
        if(isset($_POST["name"])){
            $name = $_POST["name"];
            if(isset($_POST["id"])) $pay = $_POST["id"];
            if(isset($_POST["pay"])) $pay = $_POST["pay"];
            if(isset($_POST["category"])) $category = $_POST["category"];
            $db->query('update menu_table set menu_name = "'.$name.'",menu_pay="'.$pay.'"",category="'.$category.'"" where menu_id ='.$id);
        }
    }

    if(isset($_POST["add"])){
        $add_pay = $add_name = $category = "";
            if(isset($_POST["add_name"])){ 
                $add_name = $_POST["add_name"]; 
            if(isset($_POST["add_pay"])) $add_pay = $_POST["add_pay"];                   
            $db->query('insert into menu_table (menu_id, menu_name, menu_pay, category) values (NULL,"'.$add_name.'", "'.$add_pay.'", "'.$category.'")');
            }           
            header("Location: ./menu_manage.php");
    }
    
    if(isset($_POST["del"])){
        $menu_id = "";
        if(isset($_POST["menu_id"])){
            $menu_id = $_POST["menu_id"];                  
            $db->query('delete from menu_table where menu_table.menu_id ='.$menu_id);
        }
        header("Location: ./menu_manage.php");
    }
    while($data = $stmt->fetch(PDO::FETCH_NUM)){
        echo "<tr>";
        echo "<td><input type='number' value ='$data[0]'></td>";
        echo "<td><input type='text' value ='$data[1]'></td>";
        echo "<td><input type ='text' value='$data[2]'></td>";
        echo "<td><input type ='text' value='$data[5]'</td>";
        echo "</tr>";
    }

    ?>

    </table>
    <input type="submit" value="更新" name ="send"><br>
    商品登録：
    <input type="text" placeholder="商品名" name='add_name'>
    <input type="number" placeholder="価格" name='add_pay'>
    <input type="number" placeholder="カテゴリー"  name='category'>
    <input type="submit" value="登録" name="add"><br>
    商品消除：
    <input type="number" placeholder="商品名" name='menu_id'>
    <input type="submit" value="消除" name ="del"><br>
    </form>
</body>
</html>