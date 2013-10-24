<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$yakuman_data = $m->getAjaxData();

error_log(print_r($yakuman_data, true));