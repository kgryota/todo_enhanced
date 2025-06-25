<?php
// edit.php
// タスク編集画面の雛形
// まだDB接続や処理は未実装

// URLパラメータで編集対象のタスクIDを受け取る
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    echo "タスクIDが指定されていません。";
    exit;
}

// 今のところデフォルト値だけセット（後でDBから取得予定）
$task = [
    'task' => '',
    'due_date' => '',
    'priority' => '',
    'status' => ''
];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <title>タスク編集</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7fa;
            padding: 20px;
        }
        .edit_task {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            margin: auto;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        button {
            margin-top: 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .back_link {
            display: block;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="edit_task">
        <h1>タスク編集（ID: <?php echo htmlspecialchars($task_id); ?>）</h1>
        <form action="edit.php" method="post">
            <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">

            <label for="task">タスク内容</label>
            <input type="text" id="task" name="task" value="<?php echo htmlspecialchars($task['task']); ?>" required>

            <label for="due_date">期限</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>

            <label for="priority">優先度</label>
            <select id="priority" name="priority" required>
                <option value="">選択してください</option>
                <option value="1" <?php if ($task['priority'] == 1) echo 'selected'; ?>>低</option>
                <option value="2" <?php if ($task['priority'] == 2) echo 'selected'; ?>>中</option>
                <option value="3" <?php if ($task['priority'] == 3) echo 'selected'; ?>>高</option>
            </select>

            <label for="status">状態</label>
            <select id="status" name="status" required>
                <option value="未完了" <?php if ($task['status'] == '未完了') echo 'selected'; ?>>未完了</option>
                <option value="完了" <?php if ($task['status'] == '完了') echo 'selected'; ?>>完了</option>
            </select>

            <button type="submit">更新する</button>
        </form>
        <a href="index.php" class="back_link">← タスクリストに戻る</a>
    </div>
</body>
</html>
