<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <style>
        form{
            text-align: center;
        }

        body{
            background-color :#c0c0c0;

        }

        .h2{
            margin-top: 75px;
        }

        .row{
            text-align:right;
            margin-right:230px;
            margin-top:-71px;
            margin-bottom:50px;
        }

        table{
            margin-left: auto;
            margin-right: auto;
            width: 750px;
            height:350px;
            border-width:2px;
            border-color:#1955A6;
         
        }

        th{
            background-color:#95A5A6;
        }

        td{
            background-color:white;

        }

        #count{
            background-color:#95A5A6;

        }

        .button{
            margin-top:50px;
            margin-left:-250px;
            margin-right:-250px;
            display: flex;
            justify-content: space-evenly;

        }

        .button input {
        display: flex;
        margin: 0 auto;
        padding-left:18px;
        padding-right:30px;
        height:40px;
        width: 120px;
        color: block;
        font-size: 13px;
        font-weight: 700;
        border: 2px solid #1955A6;
        border-radius: 2px;
        }

        /*.button input::after {
        content: '';
        width: 5px;
        height: 5px;
        border-top: 3px solid #2285b1;
        border-right: 3px solid #2285b1;
        transform: rotate(45deg);
        }*/

        .button input:hover {
        color: #333333;
        background-color: #dcdcdc;
        }

        /*.button input:hover::after {
        border-top: 3px solid #333333;
        border-right: 3px solid #333333;
        }*/

        .row input{
        margin: 0;
        padding-left:18px;
        padding-right:30px;
        height:30px;
        width: 100px;
        color: block;
        font-size: 10px;
        font-weight: 700;
        border: 1px solid #1955A6;
        border-radius: 2px;

        }
        .row input:hover {
        color: #333333;
        background-color: #dcdcdc;
        }


        .row1 {
        margin-left:78%;
        overflow: hidden;
        width: 300px; /*** セレクトボックスの横幅 ***/
        text-align: right;
        position: relative;
        border: 1px solid #bbbbbb; /*** セレクトボックスのボーター設定 ***/
        border-radius: 2px; /*** セレクトボックスの角丸 ***/
        background-color : white; /*** セレクトボックスの背景色 ***/
        }

        .row1 select {
        width: 100%;
        text-indent: 0.01px;
        border: none;
        outline: none;
        -webkit-appearance: none;
        padding: 8px 38px 8px 8px;
        color: #666666;
        line-height: 1.5;
        }
        
        /*.row1 select::-ms-expand {
        display: none;
        }*/

        .row1::before {
        position: absolute;
        top: 12px;
        right: 13px;
        width: 10px;
        height: 10px;
        padding: 0;
        content: '';
        border-top: 2px solid #ffffff; /*** 矢印の色 ***/
        border-right: 2px solid #ffffff; /*** 矢印の色 ***/
        pointer-events: none;
        z-index: 1;
        transform: rotate(135deg);
        }

        .row1:after { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 38px;
        content: '';
        background: #1955A6; /*** 右側の背景色 ***/
        pointer-events: none;
        }
        
    </style>
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
    require_once "All.php";
    $dbconnect = new connect();  
    ?>
    

    

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
        header("Location:Kanri.php");
    }
     //商品管理ボタン
    if(isset($_POST['menu'])){
        header("Location:Kanri.php");
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
</html>
</body>