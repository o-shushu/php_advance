<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');
require_once(ROOT_PATH .'mvc_php\Controllers\UsersController .php');

$player = new PlayerController();
// $User = new UsersController();
// $params = $User->LoginUp();
$params = $player->index();
$player->PlayersTmp();
// $User->Permission();
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
            //endif; ?>

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
            <td><a href="edit.php?act=edit&id=<?=$player['id']; ?>"
               onclick="return confirm('編集を実行しますか？')">編集</a></td>
            <td><button class="delete" id="<?=$player['id'] ?>">削除</button></td>
            
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

<!-- <script>
    function test(){
        $.ajax({url:"index.php", success:function(result){
        $("div").text(result);}
    })
    } 
</script> -->

<script type="text/javascript">
  $('.delete').click(function(){

    if(!confirm("削除を実行しますか？")) {
      return false;
    } else {
     
        id = $(this).attr('id');
        window.location.href = "index.php?act=del&id="+id;
        return $flag = 1;
    }
    // jQuery.ajax({
    // id = $(this).attr('id');
    // type: 'post',
    // url: "detail.php?id="+id, //送信先PHPファイル
    // data: {'func' : 'get_txt_content', 'argument': file_name }, //POSTするデータ
    // success: function(content){ //正常に処理が完了した時
        
    //     element.innerHTML = "<p>" + content + "</p>";
        
    }
 
);

</script>
</body>
</html>