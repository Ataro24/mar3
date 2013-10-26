<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$game_info = $m->getAjaxData();

$games = $m->loadModule('games');

try {
    $ret = $games->addGameResult($game_info);
} catch (Exception $e) {
    $ret = array($e);
}

$m->returnApi($ret);
