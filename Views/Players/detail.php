<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');

$Player = new PlayerController();
$params = $Player->view();
$player = $params['player'];
$pairings = $params['pairings'];
session_start();
var_dump($_SESSION['role']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player detail</title>
</head>
<body>
    <h1>■選手詳細</h1>
    <table>
        <tr>
            <th>NO</th>
            <td><?=$player['id'] ?></td>
        </tr>
    
        <tr>
            <th>背番号</th>
            <td><?=$player['uniform_num'] ?></td>
        </tr>
        
        <tr>
            <th>ポジション</th>
            <td><?=$player['position'] ?></td>
        </tr>
        
        <tr>
            <th>名前</th>
            <td><?=$player['name'] ?></td>
        </tr>
        
        <tr>
            <th>所属</th>
            <td><?=$player['club'] ?></td>
        </tr>
        
        <tr>
            <th>誕生日</th>
            <td><?=$player['birth'] ?></td>
        </tr>
        
        <tr>
            <th>身長</th>
            <td><?=$player['height'] ?>cm</td>
        </tr>
        
        <tr>
            <th>体重</th>
            <td><?=$player['weight'] ?>kg</td>
        </tr>
        <tr>
            <th>国籍</th>
            <td><?=$player['country_name'] ?></td>
        </tr>
        <tr>
        <?php if($_SESSION['role'] == 0):?>
        <td><a href="edit.php?act=edit&id=<?=$player['id']; ?>"
               onclick="return confirm('編集を実行しますか？')">編集</a></td>
            <td><a href="">削除</a></td>
        </tr>
    </table>
    <h1>得点履歴</h1>
    <table>
        <tr>
           <td>点数</td>
           <td>試合日時</td>  
           <td>対戦相手</td> 
           <td>ゴールタイム</td> 
        </tr>
        <?php foreach($pairings as $pairing): ?>
        <tr>
           <td><?=$pairing['score']?></td>
           <td><?=$pairing['match_time']?></td>  
           <td><?=$pairing['c_name']?></td> 
           <td><?=$pairing['gt']?></td> 
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif?>
    <p><a href="index.php">トップへ戻る</a></p>
</body>
</html>