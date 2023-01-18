<?php
require_once(ROOT_PATH .'mvc_php\Controllers\UsersController .php');

$User = new UsersController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //エスケープ処理
    $params = $User->Register();
    var_dump($params);//echoを使ったら、キーを入れます。また、F7でカタカナに交換できる。
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Login</title>
</head>
<body>
    <h1>新規画面</h1>
   <form action=" " method="post">
    <div>
        <label>
            メールアドレス：
            <input type="text" name="email" required>
        </label>
    </div>
    <div>
        <label>
            パスワード：
            <input type="password" name="password" required>
        </label>
    </div>
    <div>
        <label>
            国籍：
            <input type="text" name="country_name" required>
        </label>
    </div>
    <input type="submit" value="新規登録">
   </form>

</body>
</html>