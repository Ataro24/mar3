<?php
require_once 'Data/User.php';
class Mar_Module_Calc_Manager extends ModuleManager
{
    //TODO ドメイン駆動に
    private $calc_list;

    public $modules = array(
                            'users',
                            'games',
                            'htmlmaker_manager'
                            );


    public function __construct()
    {
        parent::__construct();
        $this->calc_list = array();
    }

    //各ユーザの成績を集計する
    public function calcurateGames()
    {    // @params int $order
        $user_list = $this->users->getAllUserList();
        $game_list = $this->games->getAllGameList();

        //ユーザ一覧を作成
        foreach ($user_list as $uid => $name) {
            if (array_key_exists($uid, $this->calc_list) === false) {
                $this->calc_list[$uid] = new Mar_Module_Calc_Data_User($uid, $name);
            }
        }

        //ゲーム情報をすべてユーザ単位で整理する
        foreach ($game_list as $g) {
            $game_info = $this->_transGameInfo($g, $user_list);
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

        $this->htmlmaker_manager->writeFileAll($user_list, $game_list, $this->calc_list);//ファイル書き出し
    }

    //集計用のデータ構造へ変換する
    private function _transGameInfo($game_data, $user_list)
    {
        $result = array(
                        1 => array('date'  => $game_data['date'],
                                   'uid'   => $this->_getUidByName($game_data['fstu'], $user_list),
                                   'point' => $game_data['fstp'],
                                   ),
                        2 => array('date'  => $game_data['date'],
                                   'uid'   => $this->_getUidByName($game_data['sndu'], $user_list),
                                   'point' => $game_data['sndp'],
                                   ),
                        3 => array('date'  => $game_data['date'],
                                   'uid'   => $this->_getUidByName($game_data['thru'], $user_list),
                                   'point' => $game_data['thrp'],
                                   ),
                        4 => array('date'  => $game_data['date'],
                                   'uid'   => $this->_getUidByName($game_data['foru'], $user_list),
                                   'point' => $game_data['forp'],
                                   ),
                        );
        return $result;
    }

    //ユーザ名をユーザidに変更する
    // @params $name      string
    // @params $user_list array
    // @return int  ユーザid
    private function _getUidByName($name, $user_list)
    {
        if (($key = array_search($name, $user_list)) === false) {
            return -1;
        }
        return $key;
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