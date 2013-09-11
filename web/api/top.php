<?php
/* require_once 'Class/Module_Base.php'; */
/* $m = Module_Base::getInstance(); */

/* var_dump($m); */
/* var_dump($m->db->hoge); */

require_once 'Class/Bootstrap.php';
$m = ApiManager::getInstance();

//var_dump($m);

/* $h = $m->loadModule('fuga')->test(); */
/* $hoge = $m->loadModule('hoge_hoge'); */




/* var_dump($h); */
/* var_dump($hoge); */


/* echo "----------\n"; */
/* $hoge->testhoge(); */


$v = $m->loadModule('user');


/* try { */
/*     //    $v->adduser('ayase'); */
/*     $v->editUserName(10,'hoge'); */
/* } catch (Exception $e) { */
/*     var_dump($e); */
/* } */


$game = $m->loadModule('game');
$ret = $game->getGameById(3);

$from_js = $m->getAjaxData();
error_log(print_r($from_js, true));


$m->returnApi($ret);


