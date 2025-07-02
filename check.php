<?php
session_start();

$pdo = new PDO(
    'mysql:host=mysql321.phy.lolipop.lan;dbname=LAA1554899-todoapp;charset=utf8',
    'LAA1554899',
    'teamproject'
);

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
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?error=empty");
    exit;
}

// DBから該当ユーザーを取得
$stmt = $pdo->prepare("SELECT * FROM username WHERE password = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

// パスワードの照合（ハッシュ化前提）
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['id'] = $username;
    $_SESSION['admin_login'] = true;
    header("Location: index.php");
    exit;
} else {
    header("Location: login.php?error=invalid");
    exit;
}
