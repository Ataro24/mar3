<?php

$get_contents = file_get_contents("php://input");
$json = json_decode($get_contents, true);

error_log(print_r($json, true));

$ret = array('ans' => 'kuroneko');

$ret_json = json_encode($ret);
header('HTTP/1.0 200 OK');
header("Content-Type: application/json; charset=UTF-8");
echo $ret_json;