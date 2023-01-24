<?php
require_once(ROOT_PATH .'\Models\Player.php');
require_once(ROOT_PATH .'\Models\Goal.php');
require_once(ROOT_PATH .'\Models\Pairing.php');
require_once(ROOT_PATH .'\Models\Countries.php');


class PlayerController {
    private $request;
    private $Player;
    private $Pairing;
    private $Country;

    public function __construct() 
    {
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] =$_POST;

        //モデルオブジェクトの生成
        $this->Player = new Player();
        //別モデルと連携
        $dbh = $this->Player->get_db_handler();
        $this->Pairing = new Pairing($dbh);
        $this->Country = new Countries($dbh);
    }

    public function index() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }
        if((isset($_SESSION['role']) && $_SESSION['role'] == 0) && isset($this->request['post']['act']) && $this->request['post']['act'] === 'del'){
            $id = $this->request['post']['id'];
            $this->Player->delFlg($id);
        }
        if(isset($this->request['get']['act']) && $this->request['get']['act'] === 'edit'){
            $id = $this->request['get']['id'];
            $editplayer_infmation = $this->Player->findById($id);
            $optioncountryid = $this->Country->findAllCountryId();
        }
        $players = $this->Player->findAll($page);
        $players_count = $this->Player->countAll();
        $players_position = $this->Player->Position();
        // $normalPlayers = array_filter($players, function($k) {//方法3:選手一覧に0なら表示、1なら非表示
        //     if($k['del_flg'] == 0){
        //         return $k;
        //     }
        // }, ARRAY_FILTER_USE_KEY);
        
        $params = [
            'players' => $players,
            'pages' => $players_count/20,
            'editplayer' => $editplayer_infmation,
            'editcountryid' => $optioncountryid ,
            'sortposition' => $players_position  
        ];
        return $params;
    }

    public function view() {
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $player = $this->Player->findById($this->request['get']['id']);
        $pairings = $this->Pairing->getGoalsByPlaeyrId($this->request['get']['id']);// debug デバッグ
        $params = [
            'player' => $player,
            'pairings' => $pairings
        ];
        return $params;
    }
    public function PlayersTmp() { //1 is interger not array
        $AllDataDelete = $this->Player->PlayersTmpDelete();
        $AllDataUpdate = $this->Player->PlayersTmpUpdate();
        $params = [
            'PlayersTmpDetele' => $AllDataDelete ,
            'PlayersTmpUpdate' => $AllDataUpdate  
        ];
        return $params;
    }
    public function EditDataCheck() {
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
          $uniform_num = test_input($_POST['uniform_num']);
          $name = test_input($_POST['name']);
          $club = test_input($_POST['club']);
          $birth = test_input($_POST['birth']);
          $height = test_input($_POST['height']);
          $weight = test_input($_POST['weight']);  
          $errors = [];
           //入力値にデータをチェックする関数の定義です。
          if(preg_match("/^[0-9]+$/", $uniform_num) == 0) {   
            $errors['uniform_num'] = '背番号は0-9の数字のみでご入力ください。';
          }
          if($height == '' || preg_match("/^[0-9]+$/", $height) == 0) {   
            $errors['height'] = 'heightは数字のみでご入力ください。';
          }
          if($weight == '' || preg_match("/^[0-9]+$/", $weight) == 0) {   
            $errors['weight'] = 'weightは数字のみでご入力ください。';
          }  
          if($name == '') {   
            $errors['name'] = '名前をご入力ください。';
          }
          if($club =='') {   
            $errors['club'] = 'クラブをご入力ください。';
          }
          if($birth == '') {   
            $errors['birth'] = '生年月日をご入力ください。';
          }
          if(!preg_match('/\A[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}\z/', $birth)) {
            $errors['birth'] = '生年月日の形式が正しくありません。';
          }else{
            list($year, $month, $day) = explode('-', $birth);
            if(checkdate($month, $day, $year) == false){
            $errors['birth'] = '日付が正しくありません。';
            }
          };
          echo $errors['uniform_num'];
          if (count($errors) > 0) {
            $params = [
                'editplayer'=> $_POST,
                'error'=> $errors
            ];
            return $params;
          } 
          if (count($errors) == 0) {
            $this->Player->updatePlayer($this->request['post']);
            $id = $this->request['post']['id'];
            $editplayer_infmation = $this->Player->findById($id);
            $params = [
                'editplayer' => $editplayer_infmation
            ];
            return $params;
            // header('Location:index.php');
          }
    }
   
}