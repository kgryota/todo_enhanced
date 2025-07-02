<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?error=empty");
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=mysql321.phy.lolipop.lan;dbname=LAA1554899-todoapp;charset=utf8',
        'LAA1554899',
        'teamproject'
    );
} catch(PDOException $e){
    die('接続できませんでした：'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_name'] = $user['username'];
    $_SESSION['admin_login'] = true;
    header("Location:./index.php");
    exit;
} else {
    header("Location:./login.php");
    exit;
}
?>