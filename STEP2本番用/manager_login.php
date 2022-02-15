<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>管理者ログイン</title>
  <link rel="stylesheet" href="css/manager_login.css">

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
    unset($_SESSION['manager']);//管理者認証をはずす
?>

<body>
  <form action="" method="post">
  <div class="login">
    <div class="form">
      <h2>管理者ログイン</h2>
      <div class="form-field">
          <label><i class="fa fa-user">ユーザー：</i></label>
          <?php echo $_SESSION['user_name'];?>
      </div>
      <div class="form-field">
        <label><i class="fa fa-lock">パスワード：</i></label>
        <input id="login-password" type="password" name="password" placeholder="Password"  required>
      </div>
      <div style="color:red;
                  text-align: center;
                  padding-bottom: 1rem">

        <?php
          if(isset($_POST['password'])){
            if($_POST['password'] != $_SESSION['pass']){
              echo 'パスワードの不一致：再度ご入力ください';
            }else if($_POST['password'] == $_SESSION['pass']){
              $_SESSION['manager'] = "";
              header("Location: kanri.php");
              exit;
            }
          }
        ?>

      </div>
      <button type="submit" class="button" name="login">
        <div class="arrow-wrapper">
          <span class="arrow"></span>
        </div>
        <p class="button-text">送信</p>
      </button>
    </div>
  </div>
  </form>

    <button type="button" class="button" name="menu" onclick="location.href='category.php'">
      <div class="arrow-wrapper">
      </div>
      <p class="button-text"> メニュー画面</p>
    </button>     
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script  src="./script.js"></script>

</body>
</html>