<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>
    <form class="login-form" action="check.php" method="POST">
        <label for="username">ユーザー名：</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">ログイン</button>
    </form>
    <a href="register.php">新規登録</a>
</body>
</html>