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
        $postemail = $this->request['post']['email'];
        $postpassword = $this->request['post']['password'];
        if(!isset($postemail) || $postemail ==""){
            $error['email'] ="メールアドレスが間違っています。";
        }
        if(!isset($postpassword) || $postpassword ==""){
            $error['password'] ="パスワードが間違っています。";
        }

        if(!empty($error)){
            return $error;
        }

        $UserLogin = $this->User->LoginDataCheck($postemail); //$UserLoginと$loginuserは取った結果が同じです。
        if(password_verify($postpassword, $UserLogin['password'])) {
            header('Location:index.php');
            exit();
        } else {
            return $error['false'] ='メールアドレスもしくはパスワードが間違っています。';
        }
    }

    public function Register() {
        $addemail = $this->request['post']['email'];
        $addcountry_name = $this->request['post']['country_name'];
        $addpassword = password_hash($this->request['post']['password'], PASSWORD_DEFAULT);
        $UserAdd = $this->User->RegisterInsert($addemail,$addcountry_name,$addpassword);
        if(isset($UserAdd)) {
             
        // $result = $stmt->rowCount();
        $result['RegisterEnd']= '新規登録が完了しました</br>
                <a href="login.php">ログインページ</a>';
        return $result;
        }
    }
    // public function Permission() {
    //     $PermissionAdd = $this->User->PermissionAdd();
    //     return $PermissionAdd;
    // }
}