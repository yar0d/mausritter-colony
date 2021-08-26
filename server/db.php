<?php

function test_mysql_conn() {
  $json = file_get_contents('.config.json');
  if (empty($json)) {
    header('(400) No config');
    exit();
  }

  $config = json_decode($json);
  if (empty($json)) {
    header('(400) No json in config');
    exit();
  }

  $mysql_server = $config->DB_HOST;
  $mysql_port = $config->DB_PORT;
  $mysql_user = $config->DB_USERNAME;
  $mysql_pass = $config->DB_PASSWORD;
  $mysql_db = $config->DB_DATABASE;

  $conn = new mysqli($mysql_server, $mysql_user, $mysql_pass, $mysql_db, $mysql_port);
  if ($conn->connect_error) {
    error_log("Connection to MySQL failed: " . $conn->connect_error);
    return "NOT WORKING";
  }
  $conn->close();
  return "OK";
};

function openDB() {
  $json = file_get_contents('.config.json');
  if (empty($json)) {
    header('HTTP/1.1 400 No config');
    exit();
  }

  $config = json_decode($json);
  if (empty($json)) {
    header('HTTP/1.1 400 No json in config');
    exit();
  }

  $mysql_server = $config->DB_HOST;
  $mysql_port = $config->DB_PORT;
  $mysql_user = $config->DB_USERNAME;
  $mysql_pass = $config->DB_PASSWORD;
  $mysql_db = $config->DB_DATABASE;

  $conn = new mysqli($mysql_server, $mysql_user, $mysql_pass, $mysql_db, $mysql_port);
  if ($conn->connect_error) {
    error_log('Connection to MySQL failed: ' . $conn->connect_error);
    header('HTTP/1.1 500 Connection to MySQL failed: ' . $conn->connect_error);
  }
  return $conn;
};

function closeDB ($conn) {
  $conn->close();
}

function saveDice ($conn, $table, $sheet, $dice) {
  $conn->query('INSERT INTO dices (vtable, sheet, json) VALUES ('.$table.','.$sheet.','.$dice.')');
}

?>