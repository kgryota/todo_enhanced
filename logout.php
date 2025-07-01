<?php
session_start(); // セッションを開始

// セッション変数をすべて削除
$_SESSION = array();

// セッションに関連付けられたクッキーも削除（セキュアな完全ログアウトのため）
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// セッションを破棄
session_destroy();

// ログインページへリダイレクト
header("Location: login.php");
exit();
