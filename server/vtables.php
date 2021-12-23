<?php
error_reporting(E_ALL & ~E_NOTICE); // DEBUG

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

$vtable = $_REQUEST["vtable"];
if (empty($vtable)) {
  header('HTTP/1.1 400 missing parameter vtable');
  exit();
}

// Load library for vtables
require "lib/core.php";
$_CORE->load("vtables");

// GET /vtables.php?vtable=<vtable>
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  header("Content-Type: application/json;charset=UTF-8");
  echo json_encode($_CORE->vtables->get($vtable));
}

// POST /vtables.php?vtable=<vtable>&opened=<0|1>
// - vtable: 'vtmc-8b06d7aa-5c13-411e-b0a8-a7abe7df84af'
// - opened: 1
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // $opened = $_REQUEST["opened"];

  // if (empty($opened)) {
  //   header('HTTP/1.1 400 missing parameter opened');
  //   exit();
  // }

  // Takes raw data from the request
  $json = file_get_contents("php://input");
  if (!isset($json)) {
    $CORE->errorMissingValue("<body>");
    exit();
  }

  $raw = json_decode($json, true);
  if (!isset($raw['data'])) $data = "";
  else $data = $raw['data'];


  header("Content-Type: application/json;charset=UTF-8");
  if (empty($_CORE->vtables->get($vtable)))
    echo $_CORE->vtables->add($vtable, $data) ? $data : $_CORE->error;
    else
    echo $_CORE->vtables->edit($vtable, $data) ? $data : $_CORE->error;
}
