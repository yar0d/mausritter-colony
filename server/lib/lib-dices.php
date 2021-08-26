<?php
class Dices {
  function getAll ($vtable) {
    return $this->core->fetchAll(
      "SELECT * FROM `dices` WHERE `vtable`=? ORDER BY `timestamp` DESC",
      [$vtable]
    );
  }

  function get ($timestamp) {
    return $this->core->fetch(
      "SELECT * FROM `dices` WHERE `timestamp`>?",
      [$timestamp]
    );
  }

  function add ($vtable, $sheet, $json) {
    return $this->core->exec(
      "INSERT INTO `dices` (`vtable`, `sheet`, `json`) VALUES (?, ?, ?)",
      [$vtable, $sheet, $json]
    );
  }

  // function edit ($name, $email, $id) {
  //   return $this->core->exec(
  //     "UPDATE `dices` SET `user_name`=?, `user_email`=? WHERE `user_id`=?",
  //     [$name, $email, $id]
  //   );
  // }

  function del ($timestamp) {
    return $this->core->exec(
      "DELETE FROM `dices` WHERE `timestamp`<=?",
      [$timestamp]
    );
  }
}
