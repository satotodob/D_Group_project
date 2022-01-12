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
        h2{
            size:100; 
            color:RED;  
         }
    </style>
    <?php
    require_once "All.php";
    $dbconnect = new connect();  
    ?>
    
    <body>
    <form method ="post" action="">
        
        <h2>エラー</h2>
        <h3>データベースに接続できませんでした</h3>
        <input type = "submit" name= "rogin_page" value= "ログインページへ戻る">   
    </body>
    <?php
    session_start();
    if(isset($_POST['rogin_page'])){
        header("Location:roguin3.php");
    }
    ?>
   
</html>

