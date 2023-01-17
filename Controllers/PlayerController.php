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
    public function keepedit() {
        // if(empty($this->request['get']['id'])) {
        //     echo '指定のパラメータが不正です。このページを表示できません。';
        //     exit;
        // }
        // $pairings = $this->Pairing->getGoalsByPlaeyrId($this->request['get']['id']);// debug デバッグ
        // $editplayer_infmation = $this->Player->updatePlayer($this->request['get']['id']);
        $this->Player->updatePlayer($this->request['post']);
        $id = $this->request['post']['id'];
        $editplayer_infmation = $this->Player->findById($id);
        $params = [
            'editplayer' => $editplayer_infmation
        ];
        return $params;
    }

    public function PlayersTmp() { //1 interger not array
        $AllDataDelete = $this->Player->PlayersTmpDelete();
        $AllDataUpdate = $this->Player->PlayersTmpUpdate();
        $params = [
            'PlayersTmpDetele' => $AllDataDelete ,
            'PlayersTmpUpdate' => $AllDataUpdate  
        ];
        return $params;
    }

}