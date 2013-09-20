<?php
define('SERVICE_NAME', 'Mar');

define('BASE', dirname(dirname(__FILE__)));
define('SERVICE_BASE', dirname(dirname(dirname(__FILE__))));
define('MODULE_PATH', dirname(dirname(__FILE__)) . '/Module');
define('BANK_PATH', dirname(dirname(__FILE__)) . '/Bank');

set_include_path(BASE . '/Class' . PATH_SEPARATOR . get_include_path());
set_include_path(BASE . '/etc' . PATH_SEPARATOR . get_include_path());

require_once 'ApiManager.php';
require_once 'ModuleManager.php';
require_once 'BankManager.php';

require_once 'db.ini.php';
