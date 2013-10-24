<?php

class Mar_Bank_File_Users extends Class_Bank_Access_File
{
    public function __construct()
    {
        $this->_file_path = BANK_PATH . '/Data/users.csv';
    }

    //ユーザ一覧を読み込む
    // @return array
    public function getAllUsers()
    {
        return $this->read();
    }

    //対局者を追加する
    // @params $name string ユーザ名
    public function addUser($name)
    {
        if (empty($name)) {
            return false;
        }
        $str_array = array($name);
        $this->writeTail($str_array);
    }

    //ユーザ一覧を$name_listで置き換える
    // @params $name_list array('taro', 'jiro', ...)
    public  function refreshUserList($name_list)
    {
        $this->write($name_list);
    }
}
