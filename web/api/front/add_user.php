<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$user_data = $m->getAjaxData();

$users = $m->loadModule('users');

try {

    if (isset($user_data['name'])) {
        $ret = $users->addUser($user_data['name']);
    } else {
        throw new Exception (
            'Invalid Data',
            100
        );
    }

} catch (Exception $e) {

    $ret = $e;

}

$m->returnApi($ret);
