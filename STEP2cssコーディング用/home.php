<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>ホーム</title>
  <link rel="stylesheet" href="./style.css">

</head>
<style>
    body{
        background-color :#c0c0c0;
        text-align: center;
    }
    h2{
        margin-top:2em;
    }
    
    .form-field button{
            box-sizing: border-box;
            display: block;
            width: 85%;
            border-width: 1px;
            border-style: solid;
            padding: 11px;
            font-family: inherit;
            font-size: 0.95em;
            margin-top:100px; 
            margin-left:auto;
            margin-right:auto;
        }

        .form-field button:hover {
            text-decoration: none;
            background-color:#bebebe
        }

        .users{
            margin:10px 0px;
            font-size:15pt;
        }

</style>

<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect();
    
    $_SESSION['user_name'] ="店長";
    
?>

<body>
    <form action="" method="post">
        <div class="login">
            <div class="form">
            <h2>ホーム</h2>

            <div class="users">
            <?php 
                echo '「'.$_SESSION['user_name'].'」でログイン中';
            ?>
            </div>

            <div class="form-field">
                <button type="submit" class="button" name="khach">
                    <div class="arrow">
                    </div>
                    <p class="button-text">お客様用画面</p>
                </button>
                <button type="submit" class="button" name="quanli">
                    <div class="arrow">
                    </div>
                    <p class="button-text">管理者用画面</p>
                </button>
            </div>
            </div>
        </div>
            </div>
    </form>
</body>
</html>
<?php
      if(isset($_POST['khach'])){
        header("Location: ./category.php");
  }
      if(isset($_POST['quanli'])){
          header("Location: ./kanri.php");
    }																																																			                                                                                                                                                                                                                                                                                                                                                        
?>