<?php

require_once '../Class/Bootstrap.php';
$m = ApiManager::getInstance();

$yakuman_data = $m->getAjaxData();

$yakumans = $m->loadModule('yakumans');

try {
    $ret = $yakumans->addYakuman($yakuman_data);
} catch (Exception $e) {
    $ret = $e;
  }

$m->returnApi($ret);
