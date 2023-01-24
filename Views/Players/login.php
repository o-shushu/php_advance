<?php
require_once(ROOT_PATH .'\Controllers\UsersController.php');

$User = new UsersController();
session_start();
$login = false;
// var_dump($_SESSION['role']);
if(isset($_SESSION['role']) && ($_SESSION['role'] == 0 || $_SESSION['role'] == 1)){
    $login = true;

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $params = $User->LoginUp();//登録のパスワードとメールアドレスをチェック
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Login</title>
</head>
<body>
    <?php if(!$login):?>
    <div class="loginborder">
        <h1>ログイン画面</h1>
        <form action=" " method="post" id="loginform">
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
            <input class="loginsubmit" type="submit" value="ログイン">
        </form>
        <p><a href="register.php">新規登録</a></p>
    </div>
    <?php else:?>
    <p>既にログインしています</p>
    <p><a href="index.php">選手一覧</a></p>
    <p><a href="logout.php">ログアウト</a></p>
    <?php endif?>
</body>
</html>