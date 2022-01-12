<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="drink.css" />
</head>
<body>
    <section id="popular" class="module">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="module-header wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                    <h2 class="module-title">串鳥</h2>
                    <h3 class="module-subtitle">Menu</h3>
                </div>
            </div>
        </div>

    <div class="menu">
        <div class="row">
            <div class="col-sm-8">
                <form action="" method="POST">
            <table border="1">
            <tr>
                <th></th>
                <th>名</th>
                <th>値段</th>
            </tr>
                <?php
                include "db.php";
                $dbconnect = new connect();
                if(isset($_POST["send"])){
                    $c_id = $c_name = "";
                    if(isset($_POST["id"])){
                        $c_id = $_POST["id"];
                        if(isset($_POST["name"])) $name = $_POST["name"][$id];
                        
                        $dbconnect->db->query('update menu_table set menu_name = "'.$name.'" where menu_id ='.$id);
                    }
                }           
                if(isset($_POST["add"])){
                    $add_pay = $add_name = $inventory = $add_del = "";
                        if(isset($_POST["add_name"])){ 
                            $add_name = $_POST["add_name"]; 
                        if(isset($_POST["add_pay"])) $add_pay = $_POST["add_pay"];                   
                        $dbconnect->db->query('insert into menu_table (menu_id, menu_name, menu_pay, menu_del, inventory) values (NULL,"'.$add_name.'", "'.$add_pay.'", "'.$add_del.'", "'.$inventory.'")');
                    }           
                        header("Location: ./manager2.php");
                }

                if(isset($_POST["del"])){
                    $id = "";
                    if(isset($_POST["id"])){
                        $id = $_POST["id"];                  
                        $dbconnect->db->query('delete from menu_table where menu_id ='.$id);
                    }
                }
                $stmt = $dbconnect->db -> query('select * from menu_table');

                while($data = $stmt->fetch(PDO::FETCH_NUM)){
                    echo "<tr>";
                    print "<td><input type='radio' value ='$data[0]' name='id'></td>";
                    echo "<td>$data[1]</td>";
                    echo "<td><input type ='text' value='$data[2]' name='name[$data[0]]'</td>";
                    echo "</tr>";
                }
                $db = null;
                ?>
                </table>
                <input type="submit" value="更新" name ="send">
                
            
            
                <input type="text" name='add_name'>
                <input type="number" name='add_pay'>
                <input type="text"  value="0" name='add_del'>
                <input type="number" max="200" value="200" name='inventory'>
                <input type="submit" value="追加" name="add">
                <input type="submit" value="消除" name ="del"><br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>