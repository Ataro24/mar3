<?php

class Mar_Bank_File_Games extends Class_Bank_Access_File
{
    public function __construct()
    {
        $this->_file_path = BANK_PATH . '/Data/games.csv';
    }

    //対局結果一覧を読み込む
    // @return array  array( 0 => "2013-10-05 taro +40 jiro +10 sabro -10 shiro -40", ...);
    public function getAllGames()
    {
        return $this->read();
    }

    //対局結果一覧を読み込む
    // @return array array( 0 => array( "date" => "2013-10-05", "fstu" => "taro", "fstp" => 40,..), ...);
    public function getAllGameArrayList()
    {
        $list = $this->read();
        if (empty($list)) {
            return array();
        }
        $result = array();
        foreach ($list as $l) {
            $ret = $this->_explodeStringToArray($l);
            if (empty($ret) === false) {
                $result[] = $ret;
            }
        }
        return $result;
    }


    //対局結果を末尾に追加する
    //@params $game_info array  対局結果(1局分)
    public function addGameResult($game_info)
    {
        if (empty($game_info)) {
            return false;
        }
        $game_info_str = $this->_transrateArrayToString($game_info);
        $str_array = array($game_info_str);
        $this->writeTail($str_array);
    }

    //対局結果を編集する
    public function editGameResult($gid, $game_info)
    {
        $game_result = $this->_transrateArrayToString($game_info);
        $game_list = $this->getAllGames();
        if (isset($game_list[$gid])) {
            //そのgidの対局は登録されている
            $game_list[$gid] = $game_result;//上書き
            $this->refreshGameList($game_list);
            return true;
        } //登録されていないならなにもしない
        return false;
    }

    //対局結果を削除する
    public function deleteGameResult($gid)
    {
        $game_list = $this->getAllGames();
        if (isset($game_list[$gid])) {
            unset($game_list[$gid]);
            $this->refreshGameList($game_list);
            return true;
        }
        return false;
    }

    public function refreshGameList($game_list)
    {
        $this->write($game_list);
    }

    //配列に収められている1局分の対局情報を文字列に変換する
    //@params $game_info array 1局分の対局情報
    //@return string           1局分の対局情報を表す文字列
    private function _transrateArrayToString($game_info)
    {
        if (empty($game_info) || is_array($game_info) === false) {
            //空、もしくは配列ではない場合、空文字を返す
            return '';
        }
        $ret = '';
        $game_info_str = '';
        foreach ($game_info as $g) {
            $game_info_str = $game_info_str . $g . ' ';
        }
        return $game_info_str;
    }

    //ファイルから読みだした文字列の対局情報を配列に変換する
    // @params $game_info string 1局分の対局情報
    // @return array             1局分の対局情報を表す配列
    private function _explodeStringToArray($game_info)
    {
        if (empty($game_info) || is_string($game_info) === false) {
            return array();
        }
        $result= array();
        $game_info = preg_replace('/[ ]+/', ' ', $game_info);//複数個のスペースを1つにする
        $exploded = explode(' ', $game_info);//スペースで区切る
        $result['date'] = $exploded[0];
        $result['fstu'] = $exploded[1];//ユーザ
        $result['fstp'] = $exploded[2];//ポイント
        $result['sndu'] = $exploded[3];
        $result['sndp'] = $exploded[4];
        $result['thru'] = $exploded[5];
        $result['thrp'] = $exploded[6];
        $result['foru'] = $exploded[7];
        $result['forp'] = $exploded[8];
        return $result;
    }
}
