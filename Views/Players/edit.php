<?php
require_once(ROOT_PATH .'mvc_php\Controllers\PlayerController.php');

$player = new PlayerController();
$params = $player->index();
  //最初没有值，提交表单后才会执行检验
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //エスケープ処理
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    
    // $id = test_input($_POST["id"]);
    $uniform_num = test_input($_POST["uniform_num"]);
    $position = test_input($_POST["position"]);
    $name = test_input($_POST["name"]);
    $club = test_input($_POST["club"]);
    $birth = test_input($_POST["birth"]);
    $height = test_input($_POST["height"]);
    $weight = test_input($_POST["weight"]);
    $country_name = test_input($_POST["country_name"]);

  $errors = [];
  $showError = false;
   //入力値にデータをチェックする関数の定義です。
  if(preg_match("/^[0-9]+$/", $uniform_num) == 0) {   
    $errors['uniform_num'] = '背番号は0-9の数字のみでご入力ください。';
  }
  if($height == '' || preg_match("/^[0-9]+$/", $height) == 0) {   
    $errors['height'] = 'heightは数字のみでご入力ください。';
  }
  if($weight == '' || preg_match("/^[0-9]+$/", $weight) == 0) {   
    $errors['weight'] = 'weightは数字のみでご入力ください。';
  }  
  if($name == '') {   
    $errors['name'] = '名前をご入力ください。';
  }
  if($club =='') {   
    $errors['club'] = 'クラブをご入力ください。';
  }
  if($birth == '') {   
    $errors['birth'] = '生年月日をご入力ください。';
  }
  if(!preg_match('/\A[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}\z/', $birth)) {
    $errors['birth'] = '生年月日の形式が正しくありません。';
  }else{
    list($year, $month, $day) = explode('-', $birth);
    if(checkdate($month, $day, $year) == false){
    $errors['birth'] = '日付が正しくありません。';
    }
  };
  if (count($errors) > 0) {
    $showError = true;
    $params['editplayer']['uniform_num'] = $uniform_num;
    $params['editplayer']['position'] = $position;
    $params['editplayer']['name'] =   $name;
    $params['editplayer']['club'] = $club;
    $params['editplayer']['birth'] =   $birth;
    $params['editplayer']['height'] =  $height;
    $params['editplayer']['weight'] = $weight;
    $params['editplayer']['country_name'] = $country_name;
  } 
  if (count($errors) == 0) {
    $player->keepedit();
    header('Location:index.php');
  }
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
            <?php if($showError && isset($errors['uniform_num'])) : ?><p style = 'color:red;'><?=$errors['uniform_num']?></p><?php endif; ?>
            <dd><input type="text" name="uniform_num" id="uniform_num" value=<?=$params['editplayer']['uniform_num'] ?>></dd>
        </dl>
            <dt>ポジション</dt>
            <select name='position'>
            <?php if($showError && isset($errors['position'])) : ?><p style = 'color:red;'><?=$errors['position']?></p><?php endif; ?>
            <option value=<?=$params['editplayer']['position'] ?>><?=$params['editplayer']['position'] ?></option>
            <option value='GK'>GK</option>
            <option value='DF'>DF</option>
            <option value='MF'>MF</option>
            <option value='FW'>FW</option>
            </select>
     
        </dl>
        <dl>
            <dt>名前</dt>
            <?php if($showError && isset($errors['name'])) : ?><p style = 'color:red;'><?=$errors['name']?></p><?php endif; ?>
            <dd><input type="text" name="name" id="name" value=<?=$params['editplayer']['name'] ?>></dd>
        </dl>
        <dl>
            <dt>所属</dt>
            <?php if($showError && isset($errors['club'])) : ?><p style = 'color:red;'><?=$errors['club']?></p><?php endif; ?>
            <dd><input type="text" name="club" id="club" value=<?=$params['editplayer']['club'] ?>></dd>
        </dl>
        <dl>
            <dt>誕生日</dt>
            <?php if($showError && isset($errors['birth'])) : ?><p style = 'color:red;'><?=$errors['birth']?></p><?php endif; ?>
            <dd><input type="text" name="birth" id="birth" value=<?=$params['editplayer']['birth'] ?>></dd>
        </dl>
        <dl>
            <dt>身長</dt>
            <?php if($showError && isset($errors['height'])) : ?><p style = 'color:red;'><?=$errors['height']?></p><?php endif; ?>
            <dd><input type="text" name="height" id="height" value=<?=$params['editplayer']['height'] ?>></dd>
        </dl>
        <dl>
            <dt>体重</dt>
            <?php if($showError && isset($errors['weight'])) : ?><p style = 'color:red;'><?=$errors['weight']?></p><?php endif; ?>
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