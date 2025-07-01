<?php
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $user_name = $_SESSION['username'];
} else {
    header("Location:./login.php");
    exit;
}

// データベース接続情報
$host = 'mysql321.phy.lolipop.lan';
$dbname = 'LAA1554899-todoapp';
$user = 'LAA1554899';
$pass = 'teamproject';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // タスクIDの取得
    $task_id = $_GET['id'] ?? '';
    
    if (empty($task_id)) {
        header("Location: index.php");
        exit;
    }

    // POST処理（更新）
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['task_content'] ?? '';
        $date = $_POST['task_date'] ?? '';
        $priority = $_POST['task_priority'] ?? '';
        $status = $_POST['task_status'] ?? '';

        // バリデーション
        if ($content && $date && $priority && $status) {
            $sql = "UPDATE todos SET task = :task, due_date = :due_date, priority = :priority, status = :status WHERE id = :id AND user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':task', $content);
            $stmt->bindParam(':due_date', $date);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $task_id);
            $stmt->bindParam(':user_id', $id);
            
            if ($stmt->execute()) {
                $message = "タスクを更新しました。";
                // 更新後にタスク情報を再取得
                $sql = "SELECT * FROM todos WHERE id = :id AND user_id = :user_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $task_id);
                $stmt->bindParam(':user_id', $id);
                $stmt->execute();
                $task = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $message = "更新に失敗しました。";
            }
        } else {
            $message = "全ての項目を入力してください。";
        }
    }

    // タスク情報の取得（初回表示またはPOST後の再取得）
    if (!isset($task)) {
        $sql = "SELECT * FROM todos WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $task_id);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            header("Location: index.php");
            exit;
        }
    }

} catch (PDOException $e) {
    $message = "データベース接続エラー: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク編集 - ToDoリスト</title>
</head>

<body>
<style>
/* ---------------------------------
   Reset CSS
   Author: Eric Meyer (modified)
---------------------------------- */
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
}

/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
  display: block;
}

/* Box sizing */
*, *::before, *::after {
  box-sizing: border-box;
}

/* Remove list styles */
ol, ul {
  list-style: none;
}

/* Remove quotes from blockquote and q */
blockquote, q {
  quotes: none;
}
blockquote::before, blockquote::after,
q::before, q::after {
  content: '';
  content: none;
}

/* Remove default table borders and spacing */
table {
  border-collapse: collapse;
  border-spacing: 0;
}

/* Remove default link styles */
a {
  text-decoration: none;
  color: inherit;
}

body{
    background-color: #f7f7fa;
}

.edit_task{
    padding: 30px;
    border-radius: 20px;
    background-color: #fff;
    margin: 20px;
}

.edit_task h1{
    font-size: 20px;
    font-weight: bold;
    padding-bottom: 20px;
}

.user_menu{
    display: flex;
    justify-content: center;
    align-items: center;
}

header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.button-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.8;
}

.message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
}

.message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

    <header>
        <h1>ToDo リスト - タスク編集</h1>
        <div class="user_menu">
            <p><?php echo htmlspecialchars($user_name). 'さん'; ?>　</p>
            <a href="logout.php">ログアウト</a>
        </div>
    </header>

    <div class="edit_task">
        <h1>タスクの編集</h1>
        
        <?php if (isset($message)): ?>
            <div class="message <?php echo (strpos($message, 'エラー') !== false || strpos($message, '失敗') !== false) ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($task)): ?>
        <form method="post">
            <div class="form-group">
                <label for="task_content">タスクの内容</label>
                <input type="text" id="task_content" name="task_content" value="<?php echo htmlspecialchars($task['task']); ?>" required>
            </div>

            <div class="form-group">
                <label for="task_date">期限</label>
                <input type="date" id="task_date" name="task_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="task_priority">優先度</label>
                <select id="task_priority" name="task_priority" required>
                    <option value="">優先度を選択</option>
                    <option value="1" <?php echo ($task['priority'] == '1') ? 'selected' : ''; ?>>優先度（低）</option>
                    <option value="2" <?php echo ($task['priority'] == '2') ? 'selected' : ''; ?>>中</option>
                    <option value="3" <?php echo ($task['priority'] == '3') ? 'selected' : ''; ?>>高</option>
                </select>
            </div>

            <div class="form-group">
                <label for="task_status">状態</label>
                <select id="task_status" name="task_status" required>
                    <option value="todo" <?php echo ($task['status'] == 'todo') ? 'selected' : ''; ?>>未完了</option>
                    <option value="in_progress" <?php echo ($task['status'] == 'in_progress') ? 'selected' : ''; ?>>進行中</option>
                    <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>完了</option>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="index.php" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>
        <?php else: ?>
            <p>タスクが見つかりません。</p>
            <a href="index.php" class="btn btn-secondary">戻る</a>
        <?php endif; ?>
    </div>

</body>
</html>