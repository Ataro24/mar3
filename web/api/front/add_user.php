<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$user_data = $m->getAjaxData();

error_log(print_r($user_data, true));

/* $users = $m->loadModule('user'); */

/* try { */
/*     $ret = $users->addUser($uname); */
    
/* } catch (Exception $e) { */

/* } */

/* $m->returnApi($ret); */