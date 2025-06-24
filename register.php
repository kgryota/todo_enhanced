<?php
// フォーム送信処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'ユーザー名とパスワードは必須です。';
    } else {
        // パスワードをハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // データベース接続情報
        $host = 'mysql321.phy.lolipop.lan';
        $dbname = 'LAA1554899-todoapp';
        $dbuser = 'LAA1554899';
        $dbpass = 'teamproject';

        try {
            // データベースに接続（PDO）
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $pdo = new PDO($dsn, $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // データ挿入（プリペアドステートメント）
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $success = '登録が完了しました！';

        } catch (PDOException $e) {
            $error = 'データベースエラー：' . $e->getMessage();
        }
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
    <form action="/view.php" method="post">
        <label for="username">ユーザー名：</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">登録</button>

        <a href="login.php">新規登録</a>

        
</body>
</html>