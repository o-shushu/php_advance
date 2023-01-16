<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');

$player = new PlayerController();
$params = $player->index();
  //変数の定義
//   $id = $params['editplayers']['id'];
  $uniform_num = $params['editplayer']['uniform_num'];
  $position = $params['editplayer']['position'];
  $name = $params['editplayer']['name'];
  $club = $params['editplayer']['club'];
  $birth = $params['editplayer']['birth'];
  $height = $params['editplayer']['height'];
  $weight = $params['editplayer']['weight'];
  $country_name = $params['editplayer']['country_name'];


  //最初没有值，提交表单后才会执行检验
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $id = test_input($_POST["id"]);
    $uniform_num = test_input($_POST["uniform_num"]);
    $position = test_input($_POST["position"]);
    $name = test_input($_POST["name"]);
    $club = test_input($_POST["club"]);
    $birth = test_input($_POST["birth"]);
    $height = test_input($_POST["position"]);
    $weight = test_input($_POST["weight"]);
    $country_name = test_input($_POST["country_name"]);
    
  }
  //エスケープ処理
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


  $errors = [];
  $showError = false;
   //入力値にデータをチェックする関数の定義です。
  if($uniform_num != '' && preg_match("/^[0-9]+$/", $uniform_num) == 0) {   
    $errors['uniform_num'] = '背番号は0-9の数字のみでご入力ください。';
  }
  if (count($errors) > 0) {
    $showError = true;
    $params['editplayer']['uniform_num'] = $uniform_num;
  } 
//   $_SESSION['id'] = $id;


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
    <form action="index.php " method="post" class="information-input">
        <dl>
            <dt>No</dt>
            <dd><input type="text" name="id" id="id" value=<?=$params['editplayer']['id'] ?>></dd>
        </dl>
        <dl>
            <dt>背番号</dt>
            <?php if($showError && isset($errors['uniform_num'])) : ?><p style = 'color:red;'><?=$errors['uniform_num']?></p><?php endif; ?>
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
            <dd><input type="text" name="name" id="name" value=<?=$params['editplayer']['name'] ?>></dd>
        </dl>
        <dl>
            <dt>所属</dt>
            <dd><input type="text" name="club" id="club" value=<?=$params['editplayer']['club'] ?>></dd>
        </dl>
        <dl>
            <dt>誕生日</dt>
            <dd><input type="text" name="birth" id="birth" value=<?=$params['editplayer']['birth'] ?>></dd>
        </dl>
        <dl>
            <dt>身長</dt>
            <dd><input type="text" name="height" id="height" value=<?=$params['editplayer']['height'] ?>></dd>
        </dl>
        <dl>
            <dt>体重</dt>
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
        <?php var_dump($params['editplayer']['country_name']);?>
        <input type='submit' value='送信' />
    </form>
</body>
</html>