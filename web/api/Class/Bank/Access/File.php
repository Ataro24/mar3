<?php
//Fileに読み書きするBankはこれを継承すること
class Class_Bank_Access_File
{
    const BANK_PATH = BANK_PATH;
    public $_file_path;

    //File読み書き用の初期化(file open)

    //fileを1行ずつ読んで配列に格納していく
    //@return array
    public function read()
    {
        if (empty($this->_file_path)) {
            return array();
            // 例外返したほうがいいか?
        }
        if (($fp = fopen($this->_file_path, "r")) === false) {
            return array();
            //きっと例外返したほうがいい
        }
        $ret = array();
        while (($buffer = fgets($fp)) !== false) {
            $buffer = str_replace(array("\r\n","\r","\n"), '', $buffer);
            if (empty($buffer) === false) { //空行は無視
                $ret[] = $buffer;
            }
        }
        fclose($fp);
        return $ret;
    }

    //fileに書き込む（追記ではない）
    //@params array @str_array  1行ごとに配列に格納されている
    public function write($str_array)
    {
        if (empty($this->_file_path)) {
            return false;
            // 例外返したほうがいいか?
        }
        if (($fp = fopen($this->_file_path, "w")) === false) {
            return false;
            //きっと例外返したほうがいい
        }
        //改行を末尾に取り付ける
        $ret = '';
        foreach ($str_array as $k => $v) {
            $str_array[$k] = $v . "\n";
            $ret = $ret . $str_array[$k];
        }
        if (fwrite($fp, $ret) === false) {
            //例外
            return false;
        }
        fclose($fp);
        return true;
    }
}