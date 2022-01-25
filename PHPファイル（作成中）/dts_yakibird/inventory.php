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
        
    </style>
    <?php
    require_once "All.php";
    $dbconnect = new connect();  
    ?>

    <?php
    if(isset($_POST['sort'])){
    if(isset($_POST['refill'])){

     }
    


?>
    
    <body>
    <form method ="post" action="">
    
    <input type="radio"  name="radio">
    <input type="submit" name="sort" value="並び変える">
    <input type="submit" name="refill" value="補充する">
   
</html>

