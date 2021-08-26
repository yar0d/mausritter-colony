<?php
error_reporting(E_ALL & ~E_NOTICE);

// (A) LOAD CORE LIBRARY
require "lib/core.php";

// (B) LOAD USER MODULE
$_CORE->load("dices");

// (C) ADD DICE
// echo $_CORE->dices->add('TEST-daniel-42', 'Achillée Pépite — Prêtresse mendiante', '{ dices: [4, 7], total: 11, success: true }') ? "OK" : $_CORE->error;
$result = var_dump($_CORE->dices->getAll());
print("<pre>" . print_r($result, true) . "</pre>");
