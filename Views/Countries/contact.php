<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="4-4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="4-4.js"></script>
    <title>Document</title>
</head>
<body>  
<?php
    //変数の定義
    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    $kana = isset($_POST['kana']) ? $_POST['kana'] : NULL;
    $tel = isset($_POST['tel']) ? $_POST['tel'] : NULL;
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $body = isset($_POST['body']) ? $_POST['body'] : NULL;
    //上記は下記の省略です。
    // if(isset($_POST['name'])){
    //   $name = $_POST['name'];
    // } else {
    //   $name = null;
    // }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = test_input($_POST["name"]);
      $kana = test_input($_POST["kana"]);
      $tel = test_input($_POST["tel"]);
      $email = test_input($_POST["email"]);
      $body = test_input($_POST["body"]);
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
    if($name == '') {
      $errors['name'] = '氏名は必須入力です。';
    }elseif(preg_match('/\A[[:^cntrl:]]{1,10}\z/u', $name) == 0) {   
      $errors['name'] = '氏名は必須入力です。10文字以内でご入力ください。';
    }
     
    if($email == ''){
      $errors['email'] = 'E-mail アドレスは必須です。';
    }else{
      $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
      if(preg_match($pattern, $email) == 0){
        $errors['email'] = 'メールアドレスは正しくご入力ください。';
      }
    }

    if($kana == '') {
      $errors['kana'] = 'フリナガは必須入力です。';
      }elseif(preg_match('/\A[[:^cntrl:]]{1,10}\z/u', $kana) == 0) {   
        $errors['kana'] = 'フリナガは必須入力です。10文字以内でご入力ください。';
      }

    if($tel != '' && preg_match("/^[0-9]+$/", $tel) == 0) {   
      $errors['tel'] = '電話番号は0-9の数字のみでご入力ください。';
    }

    if($body == '') {
      $errors['body'] = 'お問い合わせ内容は必須入力です。';
    }
    if (isset($_POST['name']) && isset($_POST['kana']) && isset($_POST['tel']) && isset($_POST['email']) && isset($_POST['body'])) {
      
      if (count($errors) > 0) {
        $showError = true;
        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['kana']= $kana;
        $_SESSION['tel']= $tel;
        $_SESSION['email']= $email;
        $_SESSION['body']= $body;
      }

      else {
        //エスケープ処理をして値を変数に格納済みの入力値
        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['kana']= $kana;
        $_SESSION['tel']= $tel;
        $_SESSION['email']= $email;
        $_SESSION['body']= $body;
        header('Location: confirm.php');
        die();
          
      }
    }

    // confirm.phpから戻ってきたときに値を保持
    if(isset($_GET['action']) && $_GET['action'] === 'edit'){
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $name = $_SESSION['name'];
      $kana = $_SESSION['kana'];
      $tel = $_SESSION['tel'];
      $email = $_SESSION['email'];
      $body = $_SESSION['body'];
      // session_destroy();
    }
?>
    <?php include "./header.php";?>
    <div class="box">
        <h2>お問い合わせ</h2><hr>
        <form action="" method="post" class="information-input">
            <h3>下記の項目をご記入の上送信ボタンを押してください</h3>
            <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
            <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
            <p><span class="required">*</span>は必須項目となります。</p>
            <dl>
                <dt><label for="name">氏名</label><span class="required">*</span></dt>
                <?php if($showError && isset($errors['name'])) : ?><p style = 'color:red;'><?=$errors['name']?></p><?php endif; ?>
                <dd><input type="text" name="name" id="name" class="validate required1" placeholder="山田太郎" value=<?=$name?>></dd>
                                                                                                                                      
                <dt><label for="kana">フリガナ</label><span class="required">*</span></dt>
                <?php if($showError && isset($errors['kana'])) : ?><p style = 'color:red;'><?=$errors['kana']?></p><?php endif; ?>
                <dd><input type="text" name="kana" class="validate required2" placeholder="ヤマダタロウ" value=<?=$kana?>></dd>

                <dt><label for="tel">電話番号</label></dt>
                <?php if($showError && isset($errors['tel'])) : ?><p style = 'color:red;'><?=$errors['tel']?></p><?php endif; ?>
                <dd><input type="text" name="tel" class="validate number" placeholder="09012345678" value=<?=$tel?>></dd>
            
                <dt><label for="email">メールアドレス</label><span class="required">*</span></dt>
                <?php if($showError && isset($errors['email'])) : ?><p style = 'color:red;'><?=$errors['email']?></p><?php endif; ?>
                <dd><input type="text" name="email" class="validate mail" placeholder="test@test.co.jp" value=<?=$email?>></dd>
            </dl>
            <h3><label for="body">お問い合わせ内容をご記入ください<span class="required">*</span></label></h3>
            <dl class="body">
                <dt class="error">
                    <?php if($showError && isset($errors['body'])) : ?><p style = 'color:red;'><?=$errors['body']?></p><?php endif; ?>
                    <dd><textarea name="body" class="validate message" rows="10" ><?= $body ?></textarea></dd>
                    <dd><button id="button" type="submit">送　信</button></dd>
                </dt>
            </dl>
        </form>
    </div>
    <script>
  $(document).ready(function (){
    $("form").submit(function(){
      var errors = "";
      
      $('p').remove('.error');
      //1行テキスト入力フォームとテキストエリアの検証
      $(":text,textarea").filter(".validate").each(function(){  
        //必須項目の検証
        $(this).filter(".message").each(function(){
          if($(this).val()==""){
            errors = errors.concat("お問い合わせ内容は必須入力です。\n");
            $(this).parent().prepend("<p class='error'>お問い合わせ内容は必須入力です。</p>");
          }
          else {
            sessionStorage.setItem($(this).attr("name"), $(this).val());
          }
        });

        $(this).filter(".required1").each(function(){
          if($(this).val()=="" || $(this).val().length > 10){
            errors = errors.concat("氏名必須項目です。10文字以内でご入力ください。\n");
            $(this).parent().prepend("<p class='error'>氏名必須項目です。10文字以内でご入力ください。</p>");
          }
          else {
            sessionStorage.setItem($(this).attr("name"), $(this).val());
          }
        });

        $(this).filter(".required2").each(function(){
          if($(this).val()=="" || $(this).val().length > 10){
            errors = errors.concat("フリガナ必須項目です。10文字以内でご入力ください。\n");
            $(this).parent().prepend("<p class='error'>フリガナ必須項目です。10文字以内でご入力ください。</p>");
          }
          else {
            sessionStorage.setItem($(this).attr("name"), $(this).val());
          }
        }); 

        $(this).filter(".number").each(function(){
          if($(this).val() !="" && !(/^([0-9]\d*|0)$/g).test($(this).val())){
            errors = errors.concat("電話番号は0-9の数字のみでご入力ください。\n");
            $(this).parent().prepend("<p class='error'>電話番号は0-9の数字のみでご入力ください。</p>");
          }
          else {
            sessionStorage.setItem($(this).attr("name"), $(this).val());
          }
        }); 

        //メールアドレスの検証
        $(this).filter(".mail").each(function(){
          if($(this).val()=="" || !(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/g).test($(this).val())){
            errors = errors.concat("E-mail アドレスは必須です。メールアドレスは正しくご入力ください。\n");
            $(this).parent().prepend("<p class='error'>E-mail アドレスは必須です。メールアドレスは正しくご入力ください。</p>");
          }
          else {
            sessionStorage.setItem($(this).attr("name"), $(this).val());
          }
        }); 
      });

      if (errors.length > 0) {
        alert(errors);

        //Session Storage に保存された値を取得
        return false;
      }
    });
  });
</script>
    <?php include "./footer.php";?>
</body>
</html>