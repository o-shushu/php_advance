<?php
require_once(ROOT_PATH .'\Controllers\PlayerController.php');
require_once(ROOT_PATH .'\Controllers\UsersController.php');

$player = new PlayerController();
$User = new UsersController();
session_start();
$login = false;
$username = "";
// var_dump($_SESSION['role']);
if(isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 0)){
    $login = true;
    // var_dump($login);
    // var_dump(isset($_SESSION['role']));
}
if($_SESSION['role'] == 1){
    $params = $User->AllUsers();
    $username = "ようこそ一般ユーザー";
    // var_dump($params);
}else{
    $params = $player->index();
    $username = "ようこそ管理ユーザー";
}
$player->PlayersTmp();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php if($login):?>
    <p><?php echo $username;?></p>
    <h2>選手一覧</h2>
    <h3><a href="logout.php">ログアウト</a></h3>
    <table>
        <tr>
            <th>No</th>
            <th>背番号</th>
            <th>ポジション</th>
            <th>名前</th>
            <th>所属</th>
            <th>誕生日</th>
            <th>身長</th>
            <th>体重</th>
            <th>国籍</th>
            <th>del_flg</th>
            <th></th>

        </tr>
        <?php foreach($params['players'] as $player):
            //if($player['del_flg']==1): continue;//方法1:選手一覧に0なら表示、1なら非表示
            //endif;
            ?>
        <tr>
            <td><?=$player['id'] ?></td>
            <td><?=$player['uniform_num'] ?></td>
            <td><?=$player['position'] ?></td>
            <td><?=$player['name'] ?></td>
            <td><?=$player['club'] ?></td>
            <td><?=$player['birth'] ?></td>
            <td><?=$player['height'] ?>cm</td>
            <td><?=$player['weight'] ?>kg</td>
            <td><?=$player['country_name'] ?></td>
            <td><?=$player['del_flg'] ?></td>
            <td><a href="detail.php?id=<?=$player['id'] ?>">詳細</a></td>
            <?php if($_SESSION['role'] == 0):?>
                <td><a href="edit.php?act=edit&id=<?=$player['id']; ?>">編集</a></td>
                <td><button class="delete" id="<?=$player['id'] ?>">削除</button></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="paging">
    <?php
    for($i=0;$i<=$params['pages'];$i++) {
        if(isset($_GET['page']) && $_GET['page'] == $i) {
            echo $i+1;
        } else {
            echo "<a href='?page=".$i."'>".($i+1)."</a>";
        }
    }
    ?>
    </div>
    <script type="text/javascript">
    $('.delete').click(function(){
        if(!confirm("削除を実行しますか？")) {
        return false;
        } else {
            id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "index.php",
                data: { "id" : id ,act : "del"}
            }).done(function(data){
               location.reload();
            }).fail(function(XMLHttpRequest, status, e){
                alert(e);
            });
        }
        }
    );

    </script>
    <?php else:?>
    <p>また、ログインできません</p>
    <h3><a href="login.php">ログイン</a></h3>
    <?php endif?>
</body>
</html>