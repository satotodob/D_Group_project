<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>デストラクタ</title>

</head>
<body>
<?php
    class connect
    {
        public $db;
        // コンストラクタ
        function __construct(){
            try {
                $this->db = new PDO('mysql:host=localhost;dbname=yakibird;charset=utf8', 'root', 'admin');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo ('データベースに接続できませんでした。' . $e->getMessage());
                exit();
            } catch (Exception $e) {
                echo ('予期せぬエラーです' . $e->getMessage());
                exit();
            }
        }
        // デストラクタ
        function __destruct(){
            $this->db = null;
        }
    }
    ?>