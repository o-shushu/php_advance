<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Pairing extends Db {
    private $table = 'pairings';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
    public function getGoalsByPlaeyrId($id = 0):Array {
        $sql = 'SELECT g.player_id,count(g.player_id) AS score,prs.kickoff AS match_time,c.name AS c_name,g.goal_time AS gt';
        $sql .= ' FROM '.$this->table .' prs';
        $sql .= ' INNER JOIN goals g ON prs.id=g.pairing_id';
        $sql .= ' INNER JOIN countries c ON prs.enemy_country_id=c.id';
        $sql .= ' WHERE g.player_id = :id';
        $sql .= ' GROUP BY g.pairing_id';
        $sql .= ' ORDER BY g.player_id ASC';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);//第3引数にPDO::PARAM_INTを指定すると, バインドする変数が整数型でない場合にエラーとなってしまう.
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);   
        return $result;
    }
}