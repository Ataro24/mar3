<?php
class ApiManager
{
    private static $_instance;
    private $_module;

    private $_json_data;

    private function __construct()
    {
        $this->_module = new ModuleManager();
    }

    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    //module呼び出し
    // @params string $class 指定されたModule以下のファイルを呼び出す
    // @return obj           指定されたクラスオブジェクト
    public function loadModule($class)
    {
        $module = $this->_module->load($class);
        return $module;
    }

    //jsから送られてきたデータを取得する
    // @return array   jsから送られてきたjsonデータを配列に変換して返す
    public function getAjaxData()
    {
        $this->_json_data = file_get_contents("php://input");
        return json_decode($this->_json_data, true);
    }

    //jsへ返答を返す
    // @params array $result  jsへ返したい配列データ
    public function returnApi($result)
    {
        header('HTTP/1.0 200 OK');
        header("Content-Type: application/json; charset=UTF-8");
        $result = json_encode($result);
        echo $result;
    }
}
