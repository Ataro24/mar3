<?php
require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$users = $m->loadModule('games');

$return = array();
try {
    $return = $users->getAllGameList();
}
catch (Exception $e) {
    error_log($e);
}

$m->returnApi($return);
