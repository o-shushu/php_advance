<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db {
    private $table = 'users';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function LoginDataCheck($postemail) {
        $sql = 'SELECT * FROM '.$this->table. ' u';
        $sql .= ' WHERE email = :email';
        $stmt = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $stmt -> bindValue(':email', $postemail);
        $stmt->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $loginuser = $stmt->fetch(PDO::FETCH_ASSOC);
        return $loginuser;
    }

    public function RegisterInsert($addemail,$addcountry_name,$addpassword) {
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
    public function CommonUser($commonuser_id) {
        $sql = 'SELECT p.*,c.name AS country_name FROM players p';
        $sql .= ' LEFT JOIN countries c ON c.id= p.country_id';
        $sql .= ' WHERE country_id = :country_id AND p.del_flg = 0';
        $stmt = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $stmt -> bindValue(':country_id', $commonuser_id);
        $stmt->execute();
        return $stmt; 
    }
}