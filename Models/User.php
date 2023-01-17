<?php
require_once(ROOT_PATH .'mvc_php/Models/Db.php');

class User extends Db {
    private $table = 'users';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function LoginDataCheck() {
        $email = $_POST['email'];
        // SELECT p.*,c.name FROM `players` p INNER JOIN countries c ON c.id= p.country_id;
        $sql = 'SELECT * FROM '.$this->table. ' u';
        $sql .= ' WHERE email = :email';
        $stmt = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $stmt -> bindValue(':email', $email);
        $stmt->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $loginuser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(password_verify($_POST['password'], $loginuser[0]['password'])) {
            $_SESSION['id'] = $loginuser['id'];
            $_SESSION['country_id'] = $loginuser['country_id'];
            header('Location:index.php');
        } else {
            $msg = 'メールアドレスもしくはパスワードが間違っています。';
        }
        echo $msg;
    }

    public function RegisterInsert() {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(email, password) VALUES (:email, :password)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email',  $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $msg = '新規登録が完了しました';
        $link = '<a href="login.php">ログインページ</a>';
        echo $msg;
        echo $link;

    }
}