<?php


require_once 'Class/Bootstrap.php';
$m = ApiManager::getInstance();

$users = $m->loadModule('user');

try {
    $ret = $users->editUsername($uid, $name);
    
} catch (Exception $e) {

}

$m->returnApi($ret);