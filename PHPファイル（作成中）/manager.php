<?php
      if(isset($_POST['home'])){
        header("Location: ./home.php");
  }
      if(isset($_POST['menu'])){
          header("Location: ./category.php");
    }	
    
        session_start();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
            if ( $password == 'supermanager') {
                $_SESSION['管理者'] = $username;
                header("Location: ./home.php");
            } else {
                $_SESSION['wrong-login'] = 'incorrect username and password';
                require "./manager_login.php";
            }
 
?>	