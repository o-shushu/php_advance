<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Goal extends Db {
    private $table = 'goals';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function findAll($page = 0):Array {
        $sql = 'SELECT * FROM '.$this->table;
        $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findById($id = 0):Array {
        $sql = 'SELECT * FROM '.$this->table;
        $sql .= ' WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM '.$this->table;
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
}