<?php
//各Moduleはこれを継承すること
class ModuleManager
{
    const MODULE_PATH = MODULE_PATH;
    private $_db;
    
    public function __construct()
    {
        $this->_db = new DataManager();
    }

    //$classで指定されたModuleを呼び出す
    // @params string $class
    // @return obj           指定されたクラスオブジェクト
    public function load($class)
    {
        $class = $this->_transrateUpper($class);

        $arc = explode('_', $class);
        $path = '';
        foreach ($arc as $a) {
            $path = $path . '/' . $a;
        }
        $name_path = self::MODULE_PATH . $path . '.php';
        $class_name = SERVICE_NAME . '_Module_' . $class;

        require_once $name_path;
        return new $class_name;
    }

    //DataBaseやFileへのアクセスマネージャの取得
    // @param  string $class  Bank以下のクラスを呼び出す
    // @return obj            指定されたクラスオブジェクト
    public function getDataManager($class)
    {
        return $this->_db->makeBank($class);
    }

    //hoge_hoge を Hoge_Hogeに変換する
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
