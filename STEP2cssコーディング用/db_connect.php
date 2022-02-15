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
                echo "<script>window.location.href = 'error.php';</script>";
                exit();
            } catch (Exception $e) {
                echo "<script>window.location.href = 'error.php';</script>";
                exit();
            }
        }
        // デストラクタ
        function __destruct(){
            $this->db = null;
        }
    }
?>