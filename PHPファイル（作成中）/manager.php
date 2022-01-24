<?php
            if(isset($_POST['login'])){
                if($_POST['username'] == null){
                    echo ("ユーザー 入力してください。");
                }else{
                    $username = $_POST['username'];
                }
                if($_POST['password'] == null){
                    echo ("パスワード 入力してください。");
                }else{
                    $password = $_POST['password'];
                }
                if($username && $password){
                    $conn = mysqli_connect("localhost", "root", "");
                    mysqli_select_db($conn, "yakibird");
                    $sql = "select * from user_table where user_name = '".$username."' and password = '".$password."' ";
                    $query = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($query)==0) {
                        $_SESSION['wrong-login'] = 'incorrect username and password';
                        require "./manager_login.php";
                    }else{
                        $_SESSION['username'] = $username;
                        header("Location: ./manager2.php");
                    } 
        
                }
            }
    
?>