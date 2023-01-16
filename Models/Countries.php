<?php
// require_once(ROOT_PATH .'mvc_php/Models/Db.php');

class Countries extends Db {
    private $table = 'countries';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function findAllCountryId():Array {
        $sql = 'SELECT id FROM '.$this->table;
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

    public function findById($id = 0):Array {//functionのテーブに気を付けます。
        $sql = 'SELECT p.*,c.name as country_name FROM '.$this->table. ' p';
        $sql .= ' INNER JOIN countries c ON c.id= p.country_id';
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
    // public function editPlayer($id) {
    // $sql = 'UPDATE players SET del_flg = :del_flg WHERE id = :id';
    // $sth = $this->dbh->prepare($sql);
    // $sth->bindParam(':id', $id, PDO::PARAM_INT);
    // $sth->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);
    // $sth->execute();
    // $result = $sth->fetch(PDO::FETCH_ASSOC);
    // return $result;//id=4,del_flg=1 array bool
    // }
}