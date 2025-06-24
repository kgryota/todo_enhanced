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
                <option value="low">優先度（低）</option>
                <option value="low">中</option>
                <option value="low">高</option>
            </select>
            <button type="submit">追加</button>
        </form>
    </div>
    <div class="search_task">
        <h1>フィルター/検索</h1>
        <form action="#" method="post">
            <input type="text" name="task_content" placeholder="タスクの内容">
            <input type="date" name="task_date">
            <select name="task_priority">
                <option value="low">優先度（低）</option>
                <option value="low">中</option>
                <option value="low">高</option>
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
            <tr>
                <td>テスト</td>
                <td>テスト</td>
                <td>テスト</td>
                <td>テスト</td>
                <td>テスト</td>
            </tr>
        </table>
    </div>
</body>
</html>