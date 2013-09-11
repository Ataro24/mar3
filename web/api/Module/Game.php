<?php
class Mar_Module_Game extends ModuleManager
{
    private $_v;
    private $_games;

    public function __construct()
    {
        parent::__construct();
        $this->_v = $this->load('validator');
        $this->_games = $this->getDataManager('games');
    }

    public function getGameList($start = null, $end = null)
    {
        $game_list = array();
        if (empty($start) && empty($end)) {
            $game_list = $this->_games->getAll();
        } else {
            $game_list = $this->_games->getGameByTimeRange($start, $end);
        }
        return $game_list;
    }

    public function getGameById($id)
    {
        $ret = $this->_games->getGameById($id);
        return $ret;
    }

    public function editGame(
                             $id = null,
                            $date,
                            $fstu, $sndu, $thru, $foru,
                            $fstp, $sndp, $thrp, $forp
                            )
    {
        $user = array(
                     'fstu' => $fstu, 
                     'sndu' => $sndu, 
                     'thru' => $thru, 
                     'foru' => $foru,
                      );
        $points = array(
                        'fstp' => $fstp, 
                        'sndp' => $sndp, 
                        'thrp' => $thrp, 
                        'forp' => $forp
                        );
        foreach ($user as $u) {
            $this->_v->validate('user_uid', array('uid' => $u));
        }
        $this->_v->validate('game', $points);
        if (empty($id)) {
            //idがないので新規登録
            $ret = $this->_games->addGame(
                                          $date,
                                          $fstu, $sndu, $thru, $foru,
                                          $fstp, $sndp, $thrp, $forp
                                          );
        } else {
            //idがあるので編集
            $ret = $this->_games->updateGame(
                                             $id,
                                             $date,
                                             $fstu, $sndu, $thru, $foru,
                                             $fstp, $sndp, $thrp, $forp
                                             );
        }

        if ($ret === false) {
            throw new Exception (
                                 'Can not add Game',
                                 100
                                 );
        }
        return true;
    }

    public function deleteGame($id)
    {
        $ret = $this->_games->deleteGame($id);
        if ($ret === false) {
            throw new Exceptoin (
                                 'Can not delete Game',
                                 100
                                 );
        }
        return true;
    }

}