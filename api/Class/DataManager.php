<?php
//各Bankはこれを継承すること
class DataManager extends PDO
{
    const BANK_PATH = BANK_PATH;
    
    public function __construct()
    {
        //Databaseアクセサ
        $ini = include 'db.ini.php';
        $dsn = sprintf("mysql:dbname=%s;host=%s", $ini['dbname'], $ini['host']);
        parent::__construct($dsn, $ini['user'], $ini['password']);

        //@TODO ファイル書き込みもできるようにしたい
    }

    //$bankで指定されたBank/を呼び出す
    // @params string $bank  Bank/以下のファイル名(小文字指定で)
    // @return obj           指定されたクラスオブジェクト
    public function makeBank($bank)
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
        //@TODO 複数ファイルを1度に読み込む
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
   
    //Databaseに対してクエリを発行する(更新系)
    // @params string $query   
    // @params array  $params  queryに当てはめる変数(プリペアードステートメント利用)
    // @return array           queryの実行結果
    public function exec($query, $params = null)
    {
        return $this->_exec_prepare($query, $params);
    }
    //プリペアードステートメントを利用してクエリ発行(更新系)
    // @params string $query
    // @params array  $params
    // @return int(作用したrow数) or false(失敗時)
    private function _exec_prepare($query, $params)
    {
        $sth = $this->prepare($query);
        foreach ($params as $k => $v) {
            $k = ':' . $k;
            $sth->bindValue($k, $v, PDO::PARAM_STR);
        }
        return $sth->execute();
    }    

    //Databaseに対してクエリを発行する(参照系)
    // @params string $query   
    // @params array  $params  queryに当てはめる変数(プリペアードステートメント利用)
    // @return array           queryの実行結果
    public function find($query, $params = null)
    {
        if (empty($params)) {
            return $this->_find_normal($query);
        } else {
            return $this->_find_prepare($query, $params);
        }
    }

    //プリペアードステートメントを利用してクエリ発行(参照系)
    // @params string $query
    // @params array  $params
    // @return array  queryの実行結果
    private function _find_prepare($query, $params)
    {
        $sth = $this->prepare($query);
        foreach ($params as $k => $v) {
            $k = ':' . $k;
            $sth->bindValue($k, $v, PDO::PARAM_STR);
        }
        $result = $sth->execute();
        return $sth->fetchAll();
    }

    //クエリの発行
    // @params string $query
    // @return array  queryの実行結果
    private function _find_normal($query)
    {
        return $this->query($query)->fetchAll();
    }
}
