<?php
error_reporting(E_ALL & ~E_NOTICE); // DEBUG

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
// header("Content-Type: application/json;charset=UTF-8");

require "lib/core.php";
$_CORE->load("sheets");

$vtable = $_REQUEST["vtable"];
if (empty($vtable)) {
  $CORE->errorMissingValue("vtable");
  exit();
}

// GET /sheets.php?vtable=<vtable>
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $result = $_CORE->sheets->getAll($vtable);
  $_CORE->respondJson($result);
}

// POST /sheets.php?vtable=<vtable>&name=<name>&str=<str>&str_max=<str_max>&dex=<dex>&dex_max=<dex_max>&wil=<wil>&wil_max=<wil_max>&hp=<hp>&hp_max=<hp_max>&level=<level>
// - vtable: "vtmc-8b06d7aa-5c13-411e-b0a8-a7abe7df84af"
// body:
// - data: Uuencoded sheet
// - hirelings: String with JSON
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_REQUEST["name"];
  if (!isset($name)) {
    $CORE->errorMissingValue("name");
    exit();
  }

  $str = $_REQUEST["str"];
  if (!isset($str)) {
    $CORE->errorMissingValue("str");
    exit();
  }

  $str_max = $_REQUEST["str_max"];
  if (!isset($str_max)) {
    $CORE->errorMissingValue("str_max");
    exit();
  }

  $dex = $_REQUEST["dex"];
  if (!isset($dex)) {
    $CORE->errorMissingValue("dex");
    exit();
  }

  $dex_max = $_REQUEST["dex_max"];
  if (!isset($dex_max)) {
    $CORE->errorMissingValue("dex_max");
    exit();
  }

  $wil = $_REQUEST["wil"];
  if (!isset($wil)) {
    $CORE->errorMissingValue("wil");
    exit();
  }

  $wil_max = $_REQUEST["wil_max"];
  if (!isset($wil_max)) {
    $CORE->errorMissingValue("wil_max");
    exit();
  }

  $hp = $_REQUEST["hp"];
  if (!isset($hp)) {
    $CORE->errorMissingValue("hp");
    exit();
  }

  $hp_max = $_REQUEST["hp_max"];
  if (!isset($hp_max)) {
    $CORE->errorMissingValue("hp_max");
    exit();
  }

  $level = $_REQUEST["level"];
  if (!isset($level)) {
    $CORE->errorMissingValue("level");
    exit();
  }

  // Takes raw data from the request
  $json = file_get_contents("php://input");
  if (!isset($json)) {
    $CORE->errorMissingValue("<body>");
    exit();
  }

  $raw = json_decode($json, true);
  if (!isset($raw['data'])) $data = "";
  else $data = $raw['data'];
  if (!isset($raw['hirelings'])) $hirelings = "[]";
  else $hirelings = json_encode($raw['hirelings']);

  // Get existing sheet, if any
  $found = $_CORE->sheets->get($vtable, $name);
  // header("Content-Type: application/json;charset=UTF-8");
  if (empty($found)) {
    // Create
    $result = $_CORE->sheets->add($vtable, $name, $str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data); // ? $_CORE->successAsJson("OK") : $_CORE->errorAsJson();
  } else {
    // Update
    $result = $_CORE->sheets->edit($vtable, $name, $str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data); // ? $_CORE->successAsJson("OK") : $_CORE->errorAsJson();
  }
  $_CORE->respond($result);
}

// DELETE /sheets.php?vtable=<vtable>&name=<name>
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
  $name = $_REQUEST["name"];
  if (!isset($name)) {
    $CORE->errorMissingValue("name");
    exit();
  }

  $result = json_encode($_CORE->sheets->del($vtable, $name));
  $_CORE->respond($result);
}
