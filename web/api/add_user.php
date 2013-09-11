<?php

require_once 'Class/Bootstrap.php';
$m = ApiManager::getInstance();

$data = $m->getJsonData($_GET['data']);

$users = $m->loadModule('user');

try {
    $ret = $users->addUser($uname);
    
} catch (Exception $e) {

}

$m->returnApi($ret);