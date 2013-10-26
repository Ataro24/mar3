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


//$v = $m->loadModule('user');


/* try { */
/*     //    $v->adduser('ayase'); */
/*     $v->editUserName(10,'hoge'); */
/* } catch (Exception $e) { */
/*     var_dump($e); */
/* } */


//$game = $m->loadModule('game');
//$ret = $game->getGameById(3);

///$from_js = $m->getAjaxData();
//error_log(print_r($from_js, true));


//$m->returnApi($ret);

/* $c = $m->loadModule('calc_manager'); */
/* $c->calcurateGames(); */

/* $c = $m->loadModule('fuga'); */
/* $c->test(); */
/* var_dump($c); */
//var_dump($c->users);

$c = $m->loadModule('users');
//var_dump($c->addUser('kirino'));
//var_dump($c->editUserName('ideyan', 'ideko'));
//var_dump($c->deleteUserName('kyousuke'));

$c = $m->loadModule('games');
//var_dump($c->getAllGameList());

$game_info = array(
                   'date'  => "2013-09-28",
                   1 => array(
                              'name'  => 'taro',
                              'point' => 10
                              ),
                   2 => array(
                              'name'  => 'jiro',
                              'point' => 40
                              ),
                   3 => array(
                              'name'  => 'sabro',
                              'point' => 10
                              ),
                   4 => array(
                              'name'  => 'goro',
                              'point' => -10
                              ),
                   );

$game_info = array();
$game_info['date'] = '2013-09-28';
$game_info[] = array(
                     'name'  => 'taro',
                     'point' => 10
                     );
$game_info[] = array(
                     'name'  => 'ochisam',
                     'point' => 40
                     );
$game_info[] = array(
                     'name'  => 'kamiyan',
                     'point' => -10
                     );
$game_info[] = array(
                     'name'  => 'hatta',
                     'point' => -40
                     );

//var_dump($game_info);
//$c->addGameResult($game_info);


$c = $m->loadModule('yakumans');
//var_dump($c->getAllYakumanList());
/* $yakuman_info = array( */
/*                       'date' => '2013-10-05', */
/*                       'name' => 'taro', */
/*                       'yaku' => '大三元' */
/* ); */
/* var_dump($c->addYakuman($yakuman_info)); */

$yakuman_info = array(
                      'date' => '2013-10-05',
                      'name' => 'taro',
                      'yaku' => '国士無双'
);
//var_dump($c->addYakuman($yakuman_info));
//var_dump($c->deleteYakuman(1));

$c = $m->loadModule('calc_manager');
var_dump($c->calcurateGames());


