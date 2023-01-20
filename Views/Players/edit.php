<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');

$player = new PlayerController();
$params = $player->index();
$optioncountry = $params['editcountryid'];
$optionposition = $params['sortposition'];
session_start();
$login = false;
// var_dump($_SESSION['role']);
if(isset($_SESSION['role']) && $_SESSION['role'] == 0){
    $login = true;
    // var_dump($login);
    // var_dump(isset($_SESSION['role']));
}
  //最初没有值，提交表单后才会执行检验
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $params = $player->EditDataCheck();
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
<?php if($login):?>
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
                <?php foreach($optionposition as $position_key => $position_val ): ?>
                    <?php if($position_val["position"] == $params['editplayer']['position']): ?>
                        <option value=<?=$position_val["position"]?> selected><?=$position_val["position"]?></option>
                    <?php else: ?>
                        <option value=<?=$position_val["position"]?>><?=$position_val["position"]?></option>
                    <?php endif?>
                <?php endforeach?>
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
                <?php 
                    foreach($optioncountry as $optioncountry_val): ?>
                        <?php if($optioncountry_val['name'] === $params['editplayer']['country_name']): ?>
                                <option value=<?=$optioncountry_val['id'] ?> selected><?=$optioncountry_val['name']?></option>
                            <?php else:?>
                                <option value=<?=$optioncountry_val['id']?>><?=$optioncountry_val['name']?></option>
                        <?php endif;?>
                <?php endforeach;?>
            </select>
        </dl>
        <input type='submit' value='送信' />
    </form>
    <?php else:?>
    <p>あなたはアクセス権限がない。</p>
    <?php endif?>
</body>
</html>