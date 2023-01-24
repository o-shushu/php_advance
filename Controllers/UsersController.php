<?php
require_once(ROOT_PATH .'\Models\User.php');

class UsersController {
    private $request;
    private $User;
    
    public function __construct() 
    {
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] =$_POST;

        //モデルオブジェクトの生成
        $this->User = new User();
   
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
                session_start();
                $_SESSION['country_id'] = $UserLogin['country_id'];
                $_SESSION['role'] = $UserLogin['role'];//$this->User->AllUsers($commonusers);
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
        $result['RegisterEnd']= '新規登録が完了しました</br>
                <a href="login.php">ログインページ</a>';
        return $result;
        }
    }
    public function AllUsers() {
        
        $commonuser_id = $_SESSION['country_id'];
        $players = $this->User->CommonUser($commonuser_id);
        $params = [
            'players' => $players 
        ];
        return $params;
    }
 
}