<?php

class Mar_Bank_File_Yakumans extends Class_Bank_Access_File
{
    public function __construct()
    {
        $this->_file_path = BANK_PATH . '/Data/yakumans.csv';
    }

    //役満情報一覧を読み込む
    // @return array
    public function getAllYakumans()
    {
        return $this->read();
    }

    //対局者を追加する
    // @params $name string ユーザ名
    public function addYakuman($yakuman_info)
    {
        if (empty($yakuman_info)) {
            return false;
        }
        $yakuman_info_str = $this->_transrateArrayToString($yakuman_info);
        $str_array = array($yakuman_info_str); 
        $ret = $this->writeTail($str_array);
        return $ret;
    }

    //役満情報を編集する
    public function editYakumanResult($yid, $yakuman_info)
    {
        $yakuman_result = $this->_transrateArrayToString($yakuman_info);
        $yakuman_list = $this->getAllYakumans();
        if (isset($yakuman_list[$yid])) {
            //そのyidの役満情報は登録されている
            $yakuman_list[$yid] = $yakuman_result;//上書き
            $this->refreshYakumanList($yakuman_list);
            return true;
        } //登録されていないならなにもしない
        return false;
    }

    //役満情報を削除する
    public function deleteYakumanResult($yid)
    {
        $yakuman_list = $this->getAllYakumans();
        if (isset($yakuman_list[$yid])) {
            unset($yakuman_list[$yid]);
            $this->refreshYakumanList($yakuman_list);
            return true;
        }
        return false;
    }



    //ユーザ一覧を$name_listで置き換える
    // @params $name_list array('taro', 'jiro', ...)
    public  function refreshYakumanList($yakuman_list)
    {
        $this->write($yakuman_list);
    }

    //配列に収められている役満情報を文字列に変換する
    //@params $yakuman_info array 役満情報
    //@return string              役満情報を表す文字列
    private function _transrateArrayToString($yakuman_info)
    {
        if (empty($yakuman_info) || is_array($yakuman_info) === false) {
            //空、もしくは配列ではない場合、空文字を返す
            return '';
        }
        $ret = '';
        $yakuman_info_str = '';
        foreach ($yakuman_info as $g) {
            $yakuman_info_str = $yakuman_info_str . $g . ' ';
        }
        return $yakuman_info_str;
    }
}
