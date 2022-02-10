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
            background-image:url("white1.jpeg");

        }

        h2{
            size:100px; 
            color:block; 
            text-align:left;
            margin:50px; 
            font-family: "Arial", "メイリオ";

         }

         h3{
            background-color:#e70000;
            color:white;
            height:30px;
            padding:5px;
            margin-top:75px; 
            margin-left:50px;
            margin-right:20px;
            
           
         }

         

        .backlogin{
            margin-top:50px;
            text-align:left;
            padding:25px;
            margin-left:25px;
        }

        .backlogin input{
            display: flex;
            justify-content: space-between;
           
            height:40px;
            width: 250px;
            color: #f8f8f8;
            font-size: 15px;
            background-color: #5e5d5d;
            /*transition: 0.3s;*/

        }

        .backlogin input::after{
            content: '';
            width: 5px;
            height: 5px;
            border-top: 3px solid #fc0101;
            border-right: 3px solid #fc0101;
            transform: rotate(45deg);
        }

        .backlogin input:hover {
            text-decoration: none;
            background-color:#8d8d8d;
        }
    </style>
    
    <body>
    <form method ="post" action="">
        <div class = "a">
        <h2>エラー</h2>
        <h3>データベースに接続できませんでした</h3>
        </div>
        <div class="backlogin">
        <input type = "submit" name= "rogin_page" value= "ログインページへ戻る">  
        </div> 
    </body>
    <?php
        session_start();
        //ログインページに行くのでセッションの情報を削除
        unset($_SESSION['user_name']);//session 'username'を削除 unset
        unset($_SESSION['pass']);//session 'password'を削除 unset
        unset($_SESSION['manager']);//管理者確認　session 'manager'を削除
        $_SESSION = array();
        setcookie(session_name(), '', time()-1, '/');
        session_destroy();

        if(isset($_POST['rogin_page'])){
        header("Location:index.php");
        }
    ?>
   
</html>

