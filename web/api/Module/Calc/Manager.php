<?php
require_once 'Data/User.php';
class Mar_Module_Calc_Manager extends ModuleManager
{
    private $_users;//ユーザ一覧
    private $_games;

    private $calc_list;

    public function __construct()
    {
        parent::__construct();
        $this->_users = $this->load('user');
        $this->_games = $this->load('game');
        $this->calc_list = array();
    }

    //各ユーザの成績を集計する
    public function calcurateGames()
    {    // @params int $order
        $user_list = $this->_users->getUserList();
        $game_list = $this->_games->getGameList();

        //ユーザ一覧を作成
        foreach ($user_list as $uid => $name) {
            if (array_key_exists($uid, $this->calc_list) === false) {
                $this->calc_list[$uid] = new Mar_Module_Calc_Data_User($uid, $name);
            }
        }
        //ゲーム情報をすべてユーザ単位で整理する
        foreach ($game_list as $g) {
            $game_info = $this->_transGameInfo($g);
            foreach ($game_info as $order => $data) {
                $this->calc_list[$data['uid']]->setGame($order, $game_info);
            }
        }

        //各ユーザの結果を集計する
        foreach ($this->calc_list as $c) {
            $c->makeSumPoint();
            $c->makeAvgOrder();
            $c->makeVsResult();
        }

        $this->load('file_manager')->writeFileAll($user_list, $game_list, $this->calc_list);

    }

    private function _transGameInfo($game_data)
    {
        $result = array(
                        1 => array('date'  => $game_data['date'],
                                   'uid'   => $game_data['fstu'],
                                   'point' => $game_data['fstp'],
                                   ),
                        2 => array('date'  => $game_data['date'],
                                   'uid'   => $game_data['sndu'],
                                   'point' => $game_data['sndp'],
                                   ),
                        3 => array('date'  => $game_data['date'],
                                   'uid'   => $game_data['thru'],
                                   'point' => $game_data['thrp'],
                                   ),
                        4 => array('date'  => $game_data['date'],
                                   'uid'   => $game_data['foru'],
                                   'point' => $game_data['forp'],
                                   ),
                        );
        return $result;
    }

    public function getOrderNumByString($order)
    {
        switch ($order) {
        case 'fstu':
            return 1;
            break;
        case 'sndu':
            return 2;
            break;
        case 'thru':
            return 3;
            break;
        case 'foru':
            return 4;
            break;
        }
    }
}