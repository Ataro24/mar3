<?php

class Mar_Module_Validator extends ModuleManager
{
    const MODULE_PATH = MODULE_PATH;

    public function __construct()
    {
        parent::__construct();
    }

    //指定したディレクトリ以下のバリデータをすべて実行する
    // @params $validator 使用するバリデータ
    // @params $params    バリデータに渡すパラメータ
    // @throw  Exception(validator)
    // @return true
    public function validate($validator, $params)
    {
        $path = $this->_makeValidatorPath($validator);
        $v_list = $this->_autoLoad($path);
        var_dump($path, $v_list);
        foreach ($v_list as $v) {
            $v->validate($params);
        }
        return true;
    }

    //指定されたディレクトリへのパスを生成する
    // @params $valdiator 使用するバリデータ
    // @return string     バリデータディレクトリへのパス
    private function _makeValidatorPath($validator)
    {
        $v_path = $this->_transrateUpper($validator);
        $arc = explode('_', $v_path);
        $path = '';
        foreach ($arc as $a) {
            $path = $path . '/' . $a;
        }
        $path = self::MODULE_PATH . '/Validator' . $path;

        return $path;
    }

    //$path以下のクラスオブジェクトをすべて生成する
    // @params  $path
    // @return  array  クラスオブジェクトリスト
    private function _autoLoad($dir)
    {
        $v_list = array();
        $file_list = $this->_searchFile($dir);
        foreach ($file_list as $f) {
            require_once $f;
            $class_name = $this->_getClassName($f);
            $v_list[] = new $class_name;
        }
        return $v_list;
    }

    //ディレクトリ$dir以下にあるすべてのphpファイルへのパスを取得する
    // @params  $dir
    // @return  array  ファイルパスのリスト
    private function _searchFile($dir)
    {
        $list = $tmp = array();
        foreach (glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
            if ($tmp = $this->_searchFile($child_dir)) {
                $list = array_merge($list, $tmp);
            }
        }
        foreach (glob($dir . '/*.php', GLOB_BRACE) as $file) {
            if (preg_match("/.*_flymake*/", $file) !== 1) {
                $list[] = $file;
            }
        }
        return $list;
    }

    //ファイルパス$pathからクラス名を生成する
    // @params $path  ファイルパス
    // @return string クラス名
    private function _getClassName($path)
    {
        $class = str_replace(self::MODULE_PATH, '', $path);
        $class = str_replace('/', '_', $class);
        $class = str_replace('.php', '', $class);
        $class = SERVICE_NAME . '_Module' . $class;
        return $class;        
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
