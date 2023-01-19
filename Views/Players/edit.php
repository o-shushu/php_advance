<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');

$player = new PlayerController();
$params = $player->index();
  //最初没有值，提交表单后才会执行检验
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $params = $player->EditDataCheck();
}
$optioncountry = $params['editcountryid'];
foreach($optioncountry as $optioncountry_key => $optioncountry_val){
    $optioncountry .= "<option value='". $optioncountry_val['name'];
    $optioncountry .= "'>". $optioncountry_val['name']. "</option>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Homepage</title>
</head>
<body>
<h2>選手一覧</h2>
    <form action=" " method="post" class="information-input">
        <dl>
            <dt>No</dt>
            <dd><input type="text" name="id" id="id" value=<?=$params['editplayer']['id'] ?>></dd>
        </dl>
        <dl>
            <dt>背番号</dt>
            <?php if(isset($params['error']['uniform_num'])) : ?><p style = 'color:red;'><?=$params['error']['uniform_num']?></p><?php endif; ?>
            <dd><input type="text" name="uniform_num" id="uniform_num" value=<?=$params['editplayer']['uniform_num'] ?>></dd>
        </dl>
            <dt>ポジション</dt>
            <select name='position'>
            <option value=<?=$params['editplayer']['position'] ?>><?=$params['editplayer']['position'] ?></option>
            <option value='GK'>GK</option>
            <option value='DF'>DF</option>
            <option value='MF'>MF</option>
            <option value='FW'>FW</option>
            </select>
     
        </dl>
        <dl>
            <dt>名前</dt>
            <?php if(isset($params['error']['name'])) : ?><p style = 'color:red;'><?=$params['error']['name']?></p><?php endif; ?>
            <dd><input type="text" name="name" id="name" value=<?=$params['editplayer']['name'] ?>></dd>
        </dl>
        <dl>
            <dt>所属</dt>
            <?php if(isset($params['error']['club'])) : ?><p style = 'color:red;'><?=$params['error']['club']?></p><?php endif; ?>
            <dd><input type="text" name="club" id="club" value=<?=$params['editplayer']['club'] ?>></dd>
        </dl>
        <dl>
            <dt>誕生日</dt>
            <?php if(isset($params['error']['birth'])) : ?><p style = 'color:red;'><?=$params['error']['birth']?></p><?php endif; ?>
            <dd><input type="text" name="birth" id="birth" value=<?=$params['editplayer']['birth'] ?>></dd>
        </dl>
        <dl>
            <dt>身長</dt>
            <?php if(isset($params['error']['height'])) : ?><p style = 'color:red;'><?=$params['error']['height']?></p><?php endif; ?>
            <dd><input type="text" name="height" id="height" value=<?=$params['editplayer']['height'] ?>></dd>
        </dl>
        <dl>
            <dt>体重</dt>
            <?php if(isset($params['error']['weight'])) : ?><p style = 'color:red;'><?=$params['error']['weight']?></p><?php endif; ?>
            <dd><input type="text" name="weight" id="weight" value=<?=$params['editplayer']['weight'] ?>></dd>
        </dl>
        <dl>
            <dt>国籍</dt>
            <select name="country_name">
                <option value=<?=$params['editplayer']['country_name'] ?>><?=$params['editplayer']['country_name'] ?></option>
                <?php // ③optionタグを出力
                echo $optioncountry; ?>
            </select>
        </dl>
        <input type='submit' value='送信' />
    </form>
</body>
</html>