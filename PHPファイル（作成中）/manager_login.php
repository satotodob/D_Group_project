<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>管理</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
  <form action="manager.php" method="post">
  <div class="login">
    <div class="form">
      <h2>管理者ログイン</h2>
      <div class="form-field">
        <label for="login-password"><i class="fa fa-lock"></i></label>
        <input id="login-password" type="password" name="password" placeholder="Password"  required>
        
      </div>
      <div style="color:red; 
                  text-align: center;
                  padding-bottom: 1rem">
        <?php if(isset($_SESSION['wrong-login'])){
          echo 'incorrect username and password';
        } ?>
      </div>
      <button type="submit" class="button">
        <div class="arrow-wrapper">
          <span class="arrow"></span>
        </div>
        <p class="button-text">SIGN IN</p>
      </button>
    </div>
  </div>
  
    <button type="submit" class="button" name="home">
      <div class="arrow-wrapper">
      </div>
      <p class="button-text">ホーム画面</p>
    </button>
    <button type="submit" class="button" name="menu">
      <div class="arrow-wrapper">
      </div>
      <p class="button-text"> メニュー画面</p>
    </button>
    </form>
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script  src="./script.js"></script>

</body>
</html>

