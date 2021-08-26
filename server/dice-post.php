<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

  require 'db.php';

  // Takes raw data from the request
  $json = file_get_contents('php://input');
  // Converts it into a PHP object
  $data = json_decode($json);

  if (empty($data)) {
    header('HTTP/1.1 400 empty payload');
    exit();
  }

  if (empty($data->table)) {
    header('HTTP/1.1 400 table is mandatory');
    exit();
  }

  if (empty($data->sheet)) {
    header('HTTP/1.1 400 sheet is mandatory');
    exit();
  }

  if (empty($data->dices)) {
    header('HTTP/1.1 400 dices is mandatory');
    exit();
  }

  if (empty($data->total)) {
    header('HTTP/1.1 400 total is mandatory');
    exit();
  }

  $text = $json.'\n';
  $handle = fopen($data->table.'-dices.json', 'a');
  fwrite($handle, $text);
  fflush($handle);
  fclose($handle);

  $conn = openDB();
  if (!empty($conn)) {
    saveDice($conn, $data->table, $data->sheet, $data->dices);
    closeDB($conn);
  }

  exit();
?>