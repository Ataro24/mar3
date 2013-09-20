<?php
//MySQLを利用するBankはこれを継承すること
class Class_Bank_Access_Mysql extends PDO
{
    const BANK_PATH = BANK_PATH;

    public function __construct()
    {
        //Databaseアクセサ
        $ini = include 'db.ini.php';
        $dsn = sprintf("mysql:dbname=%s;host=%s", $ini['dbname'], $ini['host']);
        parent::__construct($dsn, $ini['user'], $ini['password']);
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
