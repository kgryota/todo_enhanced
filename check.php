<?php
session_start();
    $pdo = new PDO(
        'mysql:host=mysql321.phy.lolipop.lan;
        dbname=LAA1554899-todoapp;charset=utf8',
        'LAA1554899',
        'teamproject'
    );
        $username = isset($_POST['username'])? htmlspecialchars($_POST['username'], ENT_QUOTES, 'utf-8') : '';
        $password = isset($_POST['password'])? htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8'): '';
        $stmt = $pdo->prepare("SELECT * FROM maneger WHERE maneger_id = ? and maneger_pass= ?");
        $stmt->execute([$sid, $password]);

        if ($username == '') {
            header("Location:./login.php");
            exit;
        }
        if ($password == '') {
            header("Location:./login.php");
            exit;
        }

        if ($stmt->rowCount()>0) {
            //ログイン許可
            //ユーザーネームを取得
            $_SESSION['user_name']=$_POST['username'];
            header("Location:./index.php");
        } else {
            //間違っているのでログイン不可
            header("Location:./login.php");
            exit;
        }
?>