<?php
class Mar_Module_Games extends ModuleManager
{
    public $modules = array(
                            'users'
                            );
    public $banks   = array(
                            'file_games'
                            );

    //対局結果一覧を取得する
    // @return array array( 0 => array( "date" => "2013-10-05", "fstu" => "taro", "fstp" => 40,..), ...);
    public function getAllGameList()
    {
        return $this->file_games->getAllGameArrayList();
    }

    //対局結果を登録する
    // @params $game_info array jsから送られてきたデータ構造
    public function addGameResult($game_info)
    {
        $this->_checkGameInfo($game_info);//ユーザがいるか、点数の合計が0かを確認
        $game_info = $this->_transrateGameInfoArrayByOrder($game_info);//jsからのデータ構造を変更する
        $ret = $this->file_games->addGameResult($game_info);
        if ($ret === false) {
            throw new Exception(
                                'Can not add Game',
                                100
                                );
        }
        return true;
    }

    //$gid行目の対局結果を$game_infoに更新する
    // @params $gid int 行番号
    // @return true
    public function editGameResult($gid, $game_info)
    {
        $this->_checkGameInfo($game_info);
        $game_info = $this->_transrateGameInfoArrayByOrder($game_info);//jsからのデータ構造を変更する
        $ret = $this->file_games->editGameResult($gid, $game_info);
        if ($ret === false) {
            throw new Exception(
                                'Can not edit Game',
                                100
                                );
        }
        return true;
    }
    //$gid行目の対局結果を削除する
    // @params $gid int
    public function deleteGameResult($gid)
    {
        $ret = $this->file_games->deleteGameResult($gid);
        if ($ret === false) {
            throw new Exception(
                                'Can not delete Game',
                                100
                                );
        }
        return true;
    }

    //対局情報が妥当なものか調べる
    // @params $game_info array jsから送られてきたデータ構造
    private function _checkGameInfo($game_info)
    {
        $this->_checkUserExist($game_info);
        $this->_checkDoubleName($game_info);
        $this->_checkSumGameResult($game_info);
    }

    // 対局情報に登録されているユーザが、usersに登録されているか調べる
    // @params $game_info array jsから送られてきたデータ構造
    private function _checkUserExist($game_info)
    {
        foreach ($game_info as $k => $u) {
            if ($k === 'date') {
                continue;
            }
            if (isset($u['name']) === false) {
                throw new Exception(
                    'Unvaliable Info',
                    100
                );
            }
            if ($ret = $this->users->isUserExist($u['name']) === false) {
                //対局したユーザが登録されていない
                throw new Exception(
                                    'User Name is Not Found',
                                    100
                                    );
            }
        }
        return true;
    }

    //対局情報に同じ名前のユーザいないか調べる
    // @parms $game_info array jsから送られてきたデータ構造
    private function _checkDoubleName($game_info)
    {
        $name_list = array();
        foreach($game_info as $key => $info) {
            if ($key != 'date') {
                error_log(print_r($info,true));
                if (array_key_exists($info['name'], $name_list) == false) {
                    $name_list[$info['name']] = $info['name'];
                } else {
                    throw new Exception(
                        'Double Count User',
                        100
                    );
                }
            }
        }
        return true;
    }

    //対局情報に登録されている点数の合計値が0かどうか調べる
    // @params $game_info array jsから送られてきたデータ構造
    private function _checkSumGameResult($game_info)
    {
        $sum = 0;
        foreach ($game_info as $k => $u) {
            if ($k === 'date') {
                continue;
            }
            $sum += (int)$u['point'];
        }
        if ($sum !== 0) {
            throw new Exception(
                                'Game Result Sum is Not 0',
                                100
                                );
        }
        return true;
    }

    // jsから送られてきたデータのデータ構造(順位は考えていない)
    // $game_info =
    //   array(
    //      'date'  => "2013-09-28",
    //      1 => array(
    //                'name'  => 'taro',
    //                'point' => 40
    //                 )
    //      2 => array(
    //                'name'  => 'jiro',
    //                'point' => 10
    //                 )
    //       ...
    //       )
    // を順番を考慮して並べ替えて
    // array(
    //       'date' => '2013-09-28',
    //       'fstu' => 'taro',
    //       'sndu' => 'jiro', ...) の形に変換する//この形になっているデータは確かなものとして扱う
    private function _transrateGameInfoArrayByOrder($game_info)
    {
        $date = $game_info['date'];
        unset($game_info['date']);
        uasort($game_info, array($this, '_sortGameInfoUser'));//点数順に並び替え

        //キー値を順位とする
        $order = 1;
        $result = array();
        $result['date'] = $date;
        foreach ($game_info as $v) {
            switch ($order) {
            case 1:
                $result['fstu'] = $v['name'];
                $result['fstp'] = $v['point'];
                break;
            case 2:
                $result['sndu'] = $v['name'];
                $result['sndp'] = $v['point'];
                break;
            case 3:
                $result['thru'] = $v['name'];
                $result['thrp'] = $v['point'];
                break;
            case 4:
                $result['foru'] = $v['name'];
                $result['forp'] = $v['point'];
                break;
            }
            $order++;
        }
        return $result;
    }

    private function _sortGameInfoUser($a, $b)
    {
        return $a['point'] < $b['point'];
    }
}