<?php
require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$users = $m->loadModule('users');

$return = array();
try {
    $return = $users->getAllUserList();
}
catch (Exception $e) {
    error_log($e);
}

$m->returnApi($return);



