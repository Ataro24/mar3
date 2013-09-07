<?php
class ApiManager
{
    private static $_instance;
    private $_module;

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
}
