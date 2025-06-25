<?php
session_start();

if ($username === '' || $password === '') {
    $error = 'ユーザー名とパスワードは必須です。';
} else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $host = 'mysql321.phy.lolipop.lan';
    $dbname = 'LAA1554899-todoapp';
    $dbuser = 'LAA1554899';
    $dbpass = 'teamproject';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        // 登録されたユーザーIDを取得（オートインクリメントされたID）
        $userId = $pdo->lastInsertId();

        // セッションに保存
        $_SESSION['id'] = $userId;
        $_SESSION['username'] = $username;

        header("Location: ./index.php");
        exit();

    } catch (PDOException $e) {
        $error = 'データベースエラー：' . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ登録画面</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form action="register.php" method="post">
        <label for="username">ユーザー名：</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">登録</button><br><br>
    

        <a href="login.php">ログインはこちら</a>

        
</body>
</html>