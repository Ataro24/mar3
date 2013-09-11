<?php
//各種機能を使うためには、Bootstrapをrequireし
//ApiManagerインスタンスを生成する
require_once 'Class/Bootstrap.php';
$m = ApiManager::getInstance();

//Module/以下のクラスを利用したい場合は
//Module名を指定してModuleインスタンスをloadする
$module = $m->loadModule('user');
$game_info = $module->getGameById(1);// 各Moduleのメソッドを利用できる

//jsとのAjax通信によって送信されたデータは
// getAjaxDataメソッドで取得可能,取得時にはphpの配列の形となっている
$from_js = $m->getAjaxData();

//jsへ返信するには
// returnApiメソッドを利用する。
$m->returnApi($ret);//引数はphpの配列でおｋ

