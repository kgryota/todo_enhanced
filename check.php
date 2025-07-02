<?php
session_start();

$pdo = new PDO(
    'mysql:host=mysql321.phy.lolipop.lan;dbname=LAA1554899-todoapp;charset=utf8',
    'LAA1554899',
    'teamproject'
);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?error=empty");
    exit;
}

// DBから該当ユーザーを取得（username を条件に）
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['user_name'] = $user['username'];
    $_SESSION['admin_login'] = true;
    header("Location: index.php");
    exit;
} else {
    header("Location: login.php?error=invalid");
    exit;
}
?>