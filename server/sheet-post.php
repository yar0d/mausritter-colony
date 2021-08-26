<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Takes raw data from the request
  $json = file_get_contents('php://input');
  // Converts it into a PHP object
  $data = json_decode($json);

  if (empty($data)) {
    header('HTTP/1.1 400 empty payload');
    exit();
  }

  if (empty($data->sheet)) {
    header('HTTP/1.1 400 sheet is mandatory');
    exit();
  }

  $text = $json.'\n';
  $handle = fopen($data->table.'-sheet.json', 'a');
  fwrite($handle, $text);
  fflush($handle);
  fclose($handle);
  exit();
?>