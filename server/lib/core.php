<?php
// (A) ERROR REPORTING
error_reporting(E_ALL & ~E_NOTICE);

$json = file_get_contents(__DIR__ . '/../config/db.config.json');
if (empty($json)) {
  header('HTTP/1.1 500 No config');
  exit();
}

$config = json_decode($json);
if (empty($json)) {
  header('HTTP/1.1 500 No json in config');
  exit();
}

// (B) DATABASE SETTINGS - CHANGE THESE TO YOUR OWN
define('DB_HOST', $config->DB_HOST);
define('DB_PORT', $config->DB_PORT);
define('DB_NAME', $config->DB_DATABASE);
define('DB_CHARSET', $config->DB_CHARSET);
define('DB_USER', $config->DB_USERNAME);
define('DB_PASSWORD', $config->DB_PASSWORD);

// (C) AUTO FILE PATHS
define('PATH_LIB', __DIR__ . DIRECTORY_SEPARATOR);

// (D) START SESSION
session_start();

// (E) INIT SYSTEM CORE
require PATH_LIB . "lib-core.php";
$_CORE = new Core();
