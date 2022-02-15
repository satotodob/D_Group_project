<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>お会計済みダミーページ</title>
</head>
<style>
     body{
        background-color:#250d00;
      }

      h1{
          text-align:center;
          margin-top:10%;
          color:white;
          font-family:serif;
      }

      header{
          background-color:#ac7c40;
          width:95%;
          padding:0.5%;
          margin-top:3%;
          margin-left:2%;
          margin-right:2%;
      }


      footer{
            background-color:#ac7c40;
            width:95%;
            height:5%;
            margin-left:2%;
            margin-right:2%;
            margin-bottom:5%;
            text-align: center;
            position: absolute;/*←絶対位置*/
            bottom: 0; /*下に固定*/
}
</style>

<?php
    session_start();
    unset($_SESSION['manager']);//管理者認証をはずす
    if(!isset($_SESSION['user_name'])){//user_nameが届かない場合(非ログイン時)
        //index.phpに飛ばします
         echo "<script>window.location.href = 'index.php';</script>";
        exit;      
    }
?>

<body>
    <header>
    　
    </header>
   
                <h1>
                お会計完了<br>
                ご利用ありがとうございました。
                </h1>

        <script>
            setTimeout(function(){
                window.location.href = 'category.php';
                }, 3*1000); //3秒後に画面遷移する
        </script>
    <footer>
            
    </footer>

</body>
</html>