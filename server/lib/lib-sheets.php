<?php
class Sheets {
  function getAll ($vtable) {
    return $this->core->fetchAll(
      "SELECT * FROM `sheets` WHERE `vtable`=? ORDER BY `name` ASC",
      [$vtable]
    );
  }

  function get ($vtable, $name) {
    return $this->core->fetch(
      "SELECT * FROM `sheets` WHERE `vtable`=? AND `name`=?",
      [$vtable, $name]
    );
  }

  function add ($vtable, $name, $str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data) {
    $created = date('Y-m-d H:i:s');
    return $this->core->exec(
      "INSERT INTO `sheets` (`vtable`, `name`, `str`, `str_max`, `dex`, `dex_max`, `wil`, `wil_max`, `hp`, `hp_max`, `level`, `hirelings`, `data`, `created`, `updated`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
      [$vtable, $name, $str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data, $created, $created]
    );
  }

  function edit ($vtable, $name, $str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data) {
    $updated = date('Y-m-d H:i:s');
    return $this->core->exec(
      "UPDATE `sheets` SET `str`=?, `str_max`=?, `dex`=?, `dex_max`=?, `wil`=?, `wil_max`=?, `hp`=?, `hp_max`=?, `level`=?, `hirelings`=?, `data`=?, `updated`=? WHERE `vtable`=? AND `name`=?",
      [$str, $str_max, $dex, $dex_max, $wil, $wil_max, $hp, $hp_max, $level, $hirelings, $data, $updated, $vtable, $name]
    );
  }

  function del ($vtable, $name) {
    return $this->core->exec(
      "DELETE FROM `sheets` WHERE `vtable`=? AND `name`=?",
      [$vtable, $name]
    );
  }
}
