<?php
require_once(ROOT_PATH .'mvc_php/Models/Db.php');

class Player extends Db {
    private $table = 'players';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function findAll($page = 0):Array {
        // SELECT p.*,c.name FROM `players` p INNER JOIN countries c ON c.id= p.country_id;
        $sql = 'SELECT p.*,c.name as country_name FROM '.$this->table. ' p';
        $sql .= ' LEFT JOIN countries c ON c.id= p.country_id';
        $sql .= ' WHERE del_flg =0';
        $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
        $sth = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $sth->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //方法2:選手一覧に0なら表示、1なら非表示
    // public function findNormalPlayers($page = 0):Array {
    //     // SELECT p.*,c.name FROM `players` p INNER JOIN countries c ON c.id= p.country_id;
    //     $sql = 'SELECT p.*,c.name as country_name FROM '.$this->table. ' p';
    //     $sql .= ' INNER JOIN countries c ON c.id= p.country_id';
    //     $sql .= ' WHERE del_flg =0';
    //     $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
    //     $sth = $this->dbh->prepare($sql);
    //     $sth->execute();//
    //     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    //     return $result;
    // }

    public function findById($id = 0) {//functionのテーブに気を付けます。
        $sql = 'SELECT p.*,c.name as country_name FROM '.$this->table. ' p';
        $sql .= ' LEFT JOIN countries c ON c.id= p.country_id';
        $sql .= ' WHERE p.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);        
        // if(!$result){
        //     return [];
        // }
        return $result;//returnすれば、後ろのことを実行しない
    }

    public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM '.$this->table;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
    public function delFlg($id) {
        $del_flg = 1;
        $sql = 'UPDATE players SET del_flg = :del_flg WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;//id=4,del_flg=1 array bool
      }
      public function findAllCountryId():Array {
        $sql = 'SELECT p.country_id,c.id,c.name FROM '.$this->table. ' p';
        $sql .= ' INNER JOIN countries c ON c.id= p.country_id';
        $sql .= ' GROUP BY c.id';
        $sth = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $sth->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function updatePlayer($UpdatedPlayerData) { //1 interger not array
        // $sql = 'UPDATE players SET uniform_num = :uniform_num
        //                         --    uniform_num = :uniform_num,
        //  WHERE id = :id';
        $sql = "UPDATE $this->table p
            SET p.uniform_num = :uniform_num,
                p.position    = :position,
                p.name        = :name,
                p.club        = :club,
                p.birth       = :birth,
                p.height      = :height,
                p.weight      = :weight,
                p.country_id  = (
                                 SELECT c.id
                                 FROM countries c
                                 WHERE c.name = :country_name
                               )
            WHERE p.id = :id";

    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id',           $UpdatedPlayerData['id'],          PDO::PARAM_INT);
    $sth->bindValue(':uniform_num',  $UpdatedPlayerData['uniform_num'], PDO::PARAM_INT);
    $sth->bindValue(':position',     $UpdatedPlayerData['position'],    PDO::PARAM_STR);
    $sth->bindValue(':name',         $UpdatedPlayerData['name'],        PDO::PARAM_STR);
    $sth->bindValue(':club',         $UpdatedPlayerData['club'],        PDO::PARAM_STR);
    $sth->bindValue(':birth',        $UpdatedPlayerData['birth'],       PDO::PARAM_STR);
    $sth->bindValue(':height',       $UpdatedPlayerData['height'],      PDO::PARAM_INT);
    $sth->bindValue(':weight',       $UpdatedPlayerData['weight'],      PDO::PARAM_INT);
    $sth->bindValue(':country_name', $UpdatedPlayerData['country_name'],PDO::PARAM_STR);
    $sth->execute();
        // $sth = $this->dbh->prepare($sql);
        // $sth->bindValue(':uniform_num', $UpdatePlayerData['uniform_num'], PDO::PARAM_INT);
        // $sth->execute();
        // $result = $sth->fetch(PDO::FETCH_ASSOC);
        // return $result;
    }
    // public function editPlayer($id) {
    // $sql = 'UPDATE players SET del_flg = :del_flg WHERE id = :id';
    // $sth = $this->dbh->prepare($sql);
    // $sth->bindParam(':id', $id, PDO::PARAM_INT);
    // $sth->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);
    // $sth->execute();
    // $result = $sth->fetch(PDO::FETCH_ASSOC);
    // return $result;//id=4,del_flg=1 array bool
    // }
    public function PlayersTmpDelete() { //1 interger not array
        $sql = 'DELETE FROM players_tmp';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
}
    public function PlayersTmpUpdate() { //1 interger not array
        $sql = 'INSERT INTO players_tmp(country, uniform_num, position, name, club, birth, height, weight )
                SELECT   c.name, p.uniform_num, p.position,p.name, p.club, p.birth, p.height, p.weight
                FROM '.$this->table.' p';
        $sql .= ' JOIN countries c ON p.country_id = c.id WHERE p.del_flg = 0 ORDER BY p.id ASC';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
}
}