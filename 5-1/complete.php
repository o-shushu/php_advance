<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="4-4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="4-4.js"></script>
    <title>complete</title>
</head>
<body>
    <?php
    session_start();
    $name  = $_SESSION['name'];
    $kana = $_SESSION['kana'];
    $tel  = $_SESSION['tel'];
    $email = $_SESSION['email'];
    $body = $_SESSION['body'];
    $id = $_SESSION['id'];
    ?>
    <?php include "./header.php";?>
    <!-- 将confirm传输到DB -->
    <?php
    if ($id > 0){
        try{
            include "access.php";
            $link_PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $query = $link_PDO->prepare("UPDATE contacts SET name= :name, kana= :kana, tel= :tel, email= :email, body= :body WHERE id = :id;");
            // 値をセット           
            $link_PDO->beginTransaction();
            $query->bindParam(':name', $name); 
            $query->bindParam(':id', $id); 
            $query->bindParam(':kana', $kana); 
            $query->bindParam(':tel', $tel); 
            $query->bindParam(':email', $email); 
            $query->bindParam(':body', $body); 
            // SQL実行
            $execute = $query->execute();
            $link_PDO->commit();
            if ($execute) {
                echo "UPDATE に成功しました。\n";
            }else{
                echo 'DB接続エラー';
            }
        }catch(PDOException $e){
            $link_PDO->rollBack();
            echo 'DB接続エラー' . $e->getMessage();
        } finally {
            echo '---トランザクション終了---';
        }
    }else{
        try{
            include "access.php";
            $link_PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//静的プレースホルダを用いるようにエミュレーションを無効化
            $query = $link_PDO->prepare('INSERT INTO contacts (name, kana, tel, email, body, created_at) VALUES(:name, :kana, :tel, :email, :body, NOW())');//プリペアドステートメントを準備
            $link_PDO->beginTransaction();//トランザクションを開始
            $query->bindParam(':name', $name); //型を指定してパラメータにバインドする
            $query->bindParam(':kana', $kana); 
            $query->bindParam(':tel', $tel); 
            $query->bindParam(':email', $email); 
            $query->bindParam(':body', $body);
            $execute = $query->execute();
            $link_PDO->commit();//データ保存などのコードに問題がなければ実行されます
            if ($execute) {
                echo "INSERT 件のデータを登録しました！";
            }else{
                echo 'DB接続エラー';
            } 
            
        }catch(PDOException $e){
            $link_PDO->rollBack();
            echo 'DB接続エラー' . $e->getMessage();
        } finally {
            echo '---トランザクション終了---';
        }
    }
    ?>
    <div class="complete">
        <h2>お問い合わせ</h2><hr>
        <div class="complete_moji">
            <p>お問い合わせ頂きありがとうございます。</p>
            <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
            <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
            <a href="4-4.php">トップへ戻る</a>
        </div>
    </div>
    <?php include "./footer.php";?>
  
</body>
</html>