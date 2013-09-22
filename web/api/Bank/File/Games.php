<?php

class Mar_Bank_File_Games extends Class_Bank_Access_File
{
    public function __construct()
    {
        $this->_file_path = BASE . '/data.csv';
    }

    public function getAllGames()
    {
        return $this->read();
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
        foreach ($game_info as $g) {
            $game_info_str = $game_info_str . $g . ' ';
        }
        return $game_info_str;
    }
}
