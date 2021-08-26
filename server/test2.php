<?php
error_reporting(E_ALL & ~E_NOTICE); // DEBUG

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

require "lib/core.php";
$_CORE->load("sheets");

$vtable = $_REQUEST["vtable"];
if (empty($vtable)) {
  $CORE->httpError(400, "missing parameter vtable");
  exit();
}

header("HTTP/1.1 200 OK");
header("Content-Type: application/json;charset=UTF-8");
echo json_encode(file_get_contents("php://input"));
exit();
?>
