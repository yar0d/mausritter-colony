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

// Load library for dices
require "lib/core.php";
$_CORE->load("dices");

// GET /dices.php?vtable=<vtable>
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  header("Content-Type: application/json;charset=UTF-8");
  echo json_encode($_CORE->dices->getAll($vtable));
}

// POST /dices.php?vtable=<vtable>&sheet=<sheet>
// - vtable: '1234-5678-abcd-efgh'
// - sheet: 'Achillée Pépite — Prêtresse mendiante'
// body :
// - json format: { "dices": [4, 7], "total": 11, "success": true }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $sheet = $_REQUEST["sheet"];
  if (empty($sheet)) {
    header('HTTP/1.1 400 missing parameter sheet');
    exit();
  }

  // Takes raw data from the request
  $json = file_get_contents('php://input');
  if (empty($json)) {
    header('HTTP/1.1 400 missing body');
    exit();
  }

  header("Content-Type: application/json;charset=UTF-8");
  $OK = $_CORE->dices->add($vtable, $sheet, $json) ? "OK" : $_CORE->error;
  if (!$OK) {
    header("HTTP/1.1 500 Internal error");
    header("Content-Type: application/json;charset=UTF-8");
    echo $_CORE->errorAsJson();
  } else {
    header('HTTP/1.1 200 OK');
    header("Content-Type: application/json;charset=UTF-8");
    echo $_CORE->successAsJson($OK);
  }
}
