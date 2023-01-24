<?php

class Countries extends Db {
    private $table = 'countries';

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
    public function findAllCountryId():Array {
        $sql = 'SELECT id,name FROM '.$this->table;
        $sth = $this->dbh->prepare($sql);//プリペアドステートメントのSQL
        $sth->execute();//execute関数を使うことによりデータベースからデータを取得することができました。
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
}