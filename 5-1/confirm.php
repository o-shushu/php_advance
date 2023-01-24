<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="4-4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="4-4.js"></script>
    <title>confirm</title>
</head>
<body>    
    <?php include "./header.php";?>
    <?php
    //SESSIONで受け取った入力値を変数に格納
        session_start();
        $name  = $_SESSION['name'];
        $kana = $_SESSION['kana'];
        $tel  = $_SESSION['tel'];
        $email = $_SESSION['email'];
        $body = $_SESSION['body'];
        $id = $_SESSION['id'];
    ?>
    <script>
        $(document).ready(function (){
            $("form").submit(function(){
                sessionStorage.removeItem("name");
                sessionStorage.removeItem("kana");
                sessionStorage.removeItem("tel");
                sessionStorage.removeItem("email");
                sessionStorage.removeItem("body");
            });
            return true;
        });
    </script>
    <section>
        <div class="tact-message">
            <h2>お問い合わせ</h2><hr>
            <form action="complete.php" method="post" class="information-input">
                <p>下記の内容をご確認の上送信ボタンを押してください</p>
                <p>内容を訂正する場合は戻るを押してください。</p>
                <dl class="confirm">
                    <dt>氏名</dt>
                    <dd><?= $name ?></dd>
                    <dt>フリガナ</dt>
                    <dd><?= $kana ?></dd>
                    <dt>電話番号</dt>
                    <dd><?= $tel ?></dd>
                    <dt>メールアドレス</dt>
                    <dd><?= $email ?></dd>
                    <dt><?php echo nl2br($body);?></dt> <!-- 「nl2br関数」は文字列内の改行コード(\nなど)をHTMLでの改行コード(<br>)に変換してくれる関数です。 -->
                    <dd>
                        Cafe-Cafe  御中<br>
                        <br>
                        いつも大変お世話になっております。<br>
                        株式会社〇〇の山田です。<br>
                        <br>
                        先日メールにてお願いしておりましたXXの商品サンプルの件についてですが、<br>
                        その後の進捗は、いかがでしょうか。<br>
                        当サンプルが必要となる会議が今週金曜日と迫っているため、本日15時までにご送付をお願いできますでしょうか。<br>
                        <br>
                        また、本メールと行き違いでご連絡をいただいておりましたら申し訳ありません。<br>
                        お忙しいところ大変恐れ入りますが、お取り計らいの程、何卒よろしくお願いいたします。
                    </dd>
                    <dd class="confirm_btn">
                        <button id="button_cfm" type="submit">送　信</button>
                        <a  href="contact.php?action=cfmedit&id=<?=$id?>"><button class="return" type="button">戻る</button> </a>
                    </dd>
                </dl>
            </form>
        </div>
    </section>
    <?php include "./footer.php";?>  
</body>
</html>