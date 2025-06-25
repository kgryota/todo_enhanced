<?php
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $user_name = $_SESSION['username'];
} else {
    header("Location:./login.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'mysql321.phy.lolipop.lan';
    $dbname = 'LAA1554899-todoapp';  // 表示と同じデータベース名に統一
    $user = 'LAA1554899';
    $pass = 'teamproject';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // POSTデータを受け取る
        $content = $_POST['task_content'] ?? '';
        $date = $_POST['task_date'] ?? '';
        $priority = $_POST['task_priority'] ?? '';

        // 簡単なバリデーション
        if ($content && $date && $priority) {
            // todosテーブルの構造に合わせて修正
            $sql = "INSERT INTO todos (id, task, due_date, priority, status) VALUES (:id, :task, :due_date, :priority, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':task', $content);
            $stmt->bindParam(':due_date', $date);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':status', $status);
            
            $id = $_SESSION['id'];  
            $status = 'todo';  // デフォルトステータス
            
            $stmt->execute();

            $message = "タスクを追加しました。";
        } else {
            $message = "全ての項目を入力してください。";
        }

    } catch (PDOException $e) {
        $message = "データベース接続エラー: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoリスト</title>
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

.add_task{
    padding: 30px;
    border-radius: 20px;
    background-color: #fff;
    margin: 20px;
}

.add_task h1{
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

.progress_bar{
    margin: 20px;
}

.search_task{
    padding: 30px;
    border-radius: 20px;
    background-color: #fff;
    margin: 20px;
}

.search_task h1{
    font-size: 20px;
    font-weight: bold;
    padding-bottom: 20px;
}

.task_list{
    padding: 30px;
    border-radius: 20px;
    background-color: #fff;
    margin: 20px;
}

.task_list h1{
    font-size: 20px;
    font-weight: bold;
    padding-bottom: 20px;
}

td{
    width: 20%;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}
</style>
    <header>
        <h1>ToDo リスト</h1>
        <div class="user_menu">
            <p><?php echo $id. 'さん'; ?>　</p>
            <a href="">ログアウト</a>
        </div>
    </header>
    <div class="progress_bar">
        <p>進捗：50%</p>
    </div>
    <div class="add_task">
        <h1>タスクの追加</h1>
        <?php if (isset($message)): ?>
            <p style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="index.php" method="post">
            <input type="text" name="task_content" placeholder="タスクの内容" required>
            <input type="date" name="task_date" required>
            <select name="task_priority" required>
                <option value="">優先度を選択</option>
                <option value="1">優先度（低）</option>
                <option value="2">中</option>
                <option value="3">高</option>
            </select>
            <button type="submit">追加</button>
        </form>
    </div>
    <div class="search_task">
        <h1>フィルター/検索</h1>
        <form action="index.php" method="get">
            <input type="text" name="search_keyword" placeholder="キーワード" value="<?php echo htmlspecialchars($_GET['search_keyword'] ?? ''); ?>">
            <input type="date" name="search_date" value="<?php echo htmlspecialchars($_GET['search_date'] ?? ''); ?>">
            <select name="search_priority">
                <option value="">優先度を選択</option>
                <option value="1" <?php echo (isset($_GET['search_priority']) && $_GET['search_priority'] == '1') ? 'selected' : ''; ?>>優先度（低）</option>
                <option value="2" <?php echo (isset($_GET['search_priority']) && $_GET['search_priority'] == '2') ? 'selected' : ''; ?>>中</option>
                <option value="3" <?php echo (isset($_GET['search_priority']) && $_GET['search_priority'] == '3') ? 'selected' : ''; ?>>高</option>
            </select>
            <button type="submit">適用</button>
            <?php if (!empty($_GET['search_keyword']) || !empty($_GET['search_date']) || !empty($_GET['search_priority'])): ?>
                <a href="index.php">クリア</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="task_list">
        <h1><?php echo (!empty($_GET['search_keyword']) || !empty($_GET['search_date']) || !empty($_GET['search_priority'])) ? '検索結果' : 'タスク一覧'; ?></h1>
        <table>
            <tr>
                <th>状態</th>
                <th>タスク</th>
                <th>期限</th>
                <th>優先度</th>
                <th>操作</th>
            </tr>
            <?php
                // データベース接続情報（統一）
                $host = 'mysql321.phy.lolipop.lan';
                $dbname = 'LAA1554899-todoapp';  // 正しいデータベース名
                $user = 'LAA1554899';
                $pass = 'teamproject';
                $charset = 'utf8mb4';

                // DSN（接続文字列）
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

                try {
                    $pdo = new PDO($dsn, $user, $pass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);

                    // 検索条件を取得
                    $search_keyword = $_GET['search_keyword'] ?? '';
                    $search_date = $_GET['search_date'] ?? '';
                    $search_priority = $_GET['search_priority'] ?? '';

                    // SQL文の組み立て
                    $sql = "SELECT * FROM `todos` WHERE `user_id` = :user_id";
                    $params = [':user_id' => 1];

                    // 検索条件がある場合の処理
                    if (!empty($search_keyword)) {
                        $sql .= " AND `task` LIKE :search_keyword";
                        $params[':search_keyword'] = "%$search_keyword%";
                    }

                    if (!empty($search_date)) {
                        $sql .= " AND `due_date` = :search_date";
                        $params[':search_date'] = $search_date;
                    }

                    if (!empty($search_priority)) {
                        $sql .= " AND `priority` = :search_priority";
                        $params[':search_priority'] = $search_priority;
                    }

                    // ソート（期限順）
                    $sql .= " ORDER BY `due_date` ASC";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($results)) {
                        foreach ($results as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['task']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                            
                            // 優先度の表示を改善
                            $priority_text = '';
                            switch($row['priority']) {
                                case 1: $priority_text = '低'; break;
                                case 2: $priority_text = '中'; break;
                                case 3: $priority_text = '高'; break;
                                default: $priority_text = '未設定'; break;
                            }
                            echo "<td>" . $priority_text . "</td>";
                            echo "<td>
                                    <button onclick=\"editTask(" . $row['id'] . ")\">編集</button>
                                    <button onclick=\"deleteTask(" . $row['id'] . ")\">削除</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>該当するタスクが見つかりません。</td></tr>";
                    }

                } catch (PDOException $e) {
                    echo "<tr><td colspan='5'>DBエラー: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
            ?>
        </table>
    </div>

    <script>
        function editTask(id) {
            // 編集機能の実装
            alert('編集機能（ID: ' + id + '）');
        }

        function deleteTask(id) {
            if (confirm('このタスクを削除しますか？')) {
                // 削除機能の実装
                alert('削除機能（ID: ' + id + '）');
            }
        }
    </script>
</body>
</html>