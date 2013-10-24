<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$game_info = $m->getAjaxData();

/* $game = $m->loadModule('game'); */

/* try { */
/*     $ret = $users->addGame($uname); */
    
/* } catch (Exception $e) { */

/* } */

/* $m->returnApi($ret); */
