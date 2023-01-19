<?php
require_once(ROOT_PATH .'mvc_php\Models\Player.php');
require_once(ROOT_PATH .'mvc_php\Models\Goal.php');
require_once(ROOT_PATH .'mvc_php\Models\Pairing.php');
// require_once(ROOT_PATH .'mvc_php\Models\Countries.php');


class PlayerController {
    private $request;
    private $Player;
    private $Goal;
    private $Pairing;
    // private $Countries;

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
        // $this->Countries = new Countries($dbh);
    }

    public function index() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }
        if(isset($this->request['get']['act']) && $this->request['get']['act'] === 'del'){
            $id = $this->request['get']['id'];
            $this->Player->delFlg($id);
        }
        if(isset($this->request['get']['act']) && $this->request['get']['act'] === 'edit'){
            $id = $this->request['get']['id'];
            $editplayer_infmation = $this->Player->findById($id);
            $optioncountryid = $this->Player->findAllCountryId();
        }
        $players = $this->Player->findAll($page);
        $players_count = $this->Player->countAll();
        // $normalPlayers = array_filter($players, function($k) {//方法3:選手一覧に0なら表示、1なら非表示
        //     if($k['del_flg'] == 0){
        //         return $k;
        //     }
        // }, ARRAY_FILTER_USE_KEY);
        session_start();
echo "1212121";
echo $_SESSION['country_id'];
echo "tttttt";
        $params = [
            'players' => $players,
            'pages' => $players_count/20,
            'editplayer' => $editplayer_infmation,
            'editcountryid' => $optioncountryid    
        ];
        // $_GET['players'] = $this->Player->findAll($page);
        // //var_dump( $_GET['players'] );
        // $players_count = $this->Player->countAll();
        // $options = array('del_flg' => 0);
        // var_dump( $options );
        // $normalPlayers = filter_input( INPUT_GET, 'players', FILTER_CALLBACK, $options);
        
        // $normalPlayers = [];
        // var_dump( $normalPlayers );
        // $params = [
        //     'players' => $normalPlayers,
        //     'pages' => $players_count/20
        // ];
        // echo "123";
        
        // var_dump($editplayer_infmation);
        // echo "123</br>";
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
    // public function keepedit() {
    //     // if(empty($this->request['get']['id'])) {
    //     //     echo '指定のパラメータが不正です。このページを表示できません。';
    //     //     exit;
    //     // }
    //     // $pairings = $this->Pairing->getGoalsByPlaeyrId($this->request['get']['id']);// debug デバッグ
    //     // $editplayer_infmation = $this->Player->updatePlayer($this->request['get']['id']);
    //     $this->Player->updatePlayer($this->request['post']);
    //     $id = $this->request['post']['id'];
    //     $editplayer_infmation = $this->Player->findById($id);
    //     $params = [
    //         'editplayer' => $editplayer_infmation
    //     ];
    //     return $params;
    // }

    public function PlayersTmp() { //1 interger not array
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
       echo $_POST["name"];
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
            // $_SESSION["uniform_num"] = $errors['uniform_num'];
            // $params['editplayer']['uniform_num'] = $_POST["uniform_num"];
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
            header('Location:index.php');
          }
    }
   
}