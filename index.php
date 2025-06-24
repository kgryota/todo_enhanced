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

td{
    width: 20%;
    text-align: center;
}

</style>
    <header>
        <h1>ToDo リスト</h1>
        <div class="user_menu">
            <p>○○さん</p>
            <a href="#">ログアウト</a>
        </div>
    </header>
    <div class="progress_bar">
        <p>進捗：50%</p>
    </div>
    <div class="add_task">
        <h1>タスクの追加</h1>
        <form action="#" method="post">
            <input type="text" name="task_content" placeholder="タスクの内容">
            <input type="date" name="task_date">
            <select name="task_priority">
                <option value="1">優先度（低）</option>
                <option value="2">中</option>
                <option value="3">高</option>
            </select>
            <button type="submit">追加</button>
        </form>
    </div>
    <div class="search_task">
        <h1>フィルター/検索</h1>
        <form action="index.php" method="post">
            <input type="text" name="search_keyword" placeholder="キーワード">
            <input type="date" name="task_date">
            <select name="task_priority">
                <option value="1">優先度（低）</option>
                <option value="2">中</option>
                <option value="3">高</option>
            </select>
            <button type="submit">適用</button>
        </form>
    </div>
    <div class="task_list">
        <table>
            <tr>
                <th>状態</th>
                <th>タスク</th>
                <th>期限</th>
                <th>優先度</th>
                <th>操作</th>
            </tr>
            <?php
                // データベース接続情報
                $host = 'mysql321.phy.lolipop.lan';
                $dbname = 'LAA1554899-todoapp';
                $user = 'LAA1554899';
                $pass = 'teamproject';
                $charset = 'utf8mb4';

                // DSN（接続文字列）
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

                if(isset($_POST['search_keyword'])){
                    #検索処理
                    echo "<h1>検索結果<h1>";
                    
                }

                // 接続とクエリ実行
                $pdo = new PDO($dsn, $user, $pass);
                foreach ($pdo->query('SELECT * FROM `todos` WHERE `user_id` = 1') as $row) {
                    echo "<tr>";
                    echo "<td>". $row['status'] . "</td>";
                    echo "<td>". $row['task'] . "</td>";
                    echo "<td>". $row['due_date'] . "</td>";
                    echo "<td>". $row['priority'] . "</td>";
                    echo "<td>aaa</td>";
                    echo "</tr>";
                }
            ?>

        </table>
    </div>
</body>
</html>