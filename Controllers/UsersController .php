<?php
require_once(ROOT_PATH .'mvc_php\Models\User.php');
// require_once(ROOT_PATH .'mvc_php\Models\Countries.php');


class UsersController {
    private $request;
    // private $Player;
    // private $Pairing;
    private $User;
    // private $Countries;

    public function __construct() 
    {
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] =$_POST;

        //モデルオブジェクトの生成
        $this->User = new User();
        //別モデルと連携
        // $dbh = $this->Player->get_db_handler();
        // $this->Pairing = new Pairing($dbh);
        // $this->Countries = new Countries($dbh);
    }

    public function LoginUp() {
        $UserLogin = $this->User->LoginDataCheck($this->request['post']);
        return $UserLogin;
    }
    public function Register() {
        $UserAdd = $this->User->RegisterInsert();
        return $UserAdd;
    }
    // public function Eorror() {
        
    // }
}