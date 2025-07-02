<?php
if(isset($_POST['username'])){
     $user_name = $_POST['username'];
   }

   if(isset($_POST['password'])){
     $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
   }


 try {
      // データベースに接続

$pdo = new PDO(
    'mysql:host=mysql321.phy.lolipop.lan;dbname=LAA1554899-todoapp;charset=utf8',
    'LAA1554899',
    'teamproject'
);
}catch(PDOException $e){
          echo '接続できませんでした。理由：'.$e->getMessage();
      }

      if($user === false || password_verify($password, $user['password']) === false){
          echo 'ログインできませんでした';
        }
        else{
          echo 'ログイン成功';
        }

?>