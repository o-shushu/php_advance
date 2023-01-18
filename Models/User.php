<?php
require_once(ROOT_PATH .'mvc_php/Models/Db.php');

class User extends Db {
    private $table = 'users';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function LoginDataCheck($postemail) {
        // SELECT p.*,c.name FROM `players` p INNER JOIN countries c ON c.id= p.country_id;
        $sql = 'SELECT * FROM '.$this->table. ' u';
        $sql .= ' WHERE email = :email';
        $stmt = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $stmt -> bindValue(':email', $postemail);
        $stmt->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $loginuser = $stmt->fetch(PDO::FETCH_ASSOC);
        return $loginuser;
    }

    public function RegisterInsert($addemail,$addcountry_name,$addpassword) {
        // $sql = "INSERT INTO users(email, password,country_id)";
        // $sql .= ' VALUES (:email, :password, SELECT )';
        $sql = "INSERT INTO users
            SET email      = :email,
                password   = :password,
                role       = 1,
                country_id = (
                                 SELECT c.id
                                 FROM countries c
                                 WHERE c.name = :country_name
                               )";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email',  $addemail, PDO::PARAM_STR);
        $stmt->bindValue(':password', $addpassword, PDO::PARAM_STR);
        $stmt->bindValue(':country_name', $addcountry_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;            
    }
    // public function PermissionAdd() {
    //     $sql = 'GRANT ALL PRIVILEGES ON wordcup2014.* TO 0@localhost';
    //     $sql .= ' IDENTIFIED BY "password"';
    //     $stmt = $this->dbh->prepare($sql);
    //     $stmt->execute();
    //     echo "パーミッション";

    // }
}