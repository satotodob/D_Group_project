<!DOCTYPE html>
<html lang="ja" >
<head>
  <meta charset="UTF-8">
  <title>確定</title>
  <style>
      body{
        background-color:#250d00;
      }

      h2{
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

</head>

<?php
    session_start();
    
?>

<body>
        <header>
        　
</header>

                <h2>
                ご注文ありがとうございます。<br>
                ご注文が確定しました。しばらくお待ちください。
                </h2>
        <footer>
            
</footer>
      
        <script>
            setTimeout(function(){
                window.location.href = 'category.php';
                }, 5*1000); //5秒後に画面遷移する
        </script>

</body>
</html>