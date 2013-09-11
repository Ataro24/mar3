<?php

require_once 'Class/Bootstrap.php';
$m = ApiManager::getInstance();

//$data = $m->getJsonData($_GET['data']);

$game = $m->loadModule('game');

try {
    $ret = $users->addGame($uname);
    
} catch (Exception $e) {

}

$m->returnApi($ret);
