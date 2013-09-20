<?php
require 'Bank/Access/Mysql.php';
require 'Bank/Access/File.php';
//データアクセサ
class BankManager
{
    const BANK_PATH = BANK_PATH;

    public function __construct()
    {
    }

    //$bankで指定されたBank/を呼び出す
    // @params string $bank  Bank/以下のファイル名(小文字指定で)
    // @return obj           指定されたクラスオブジェクト
    public function loadBank($bank)
    {
        $bank = $this->_transrateUpper($bank);
        $arc = explode('_', $bank);
        $name = '';
        foreach ($arc as $a) {
            $name = $name . '/' . $a;
        }
        $name_path = self::BANK_PATH . $name . '.php';
        $class_name = SERVICE_NAME . '_Bank_' . $bank;

        require_once $name_path;
        return new $class_name;
    }

    //hoge_hoge をHoge_Hogeに変換する
    // @params string $name
    // @params string
    private function _transrateUpper($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '_', $name);
        return $name;
    }
}
