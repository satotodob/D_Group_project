<?php  
        session_start();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
            if ( $password == 'supermanager') {
                $_SESSION['管理者'] = $username;
                header("Location: ./manager2.php");
            } else {
                $_SESSION['wrong-login'] = 'incorrect username and password';
                require "./manager_login.php";
            }
 
?>