<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>ホーム</title>
  <link rel="stylesheet" href="./style.css">

</head>

<?php
    session_start();
    require_once "db_connect.php";
    $dbconnect = new connect();
    
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
    <form action="" method="post">
        <div class="login">
            <div class="form">
            <h2>ホーム</h2>
            <div class="form-field">
                <button type="submit" class="button" name="khach">
                    <div class="arrow-wrapper">
                    </div>
                    <p class="button-text">お客様用画面</p>
                </button>
                <button type="submit" class="button" name="quanli">
                    <div class="arrow-wrapper">
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
          header("Location: ./manager_login.php");
    }


    //ログアウトボタン作った場合
    if(isset($_POST['logout'])){
         //セッションの情報を削除
         unset($_SESSION['uname']);//session 'userName'を削除 unset
         unset($_SESSION['pass']);//session 'Password'を削除 unset
         $_SESSION = array();
         setcookie(session_name(), '', time()-1, '/');
         session_destroy();
        //index.phpに遷移
         header("Location: ./index.php");
            exit;
  }
?>