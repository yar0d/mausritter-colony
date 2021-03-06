<?php
class Vtables {
  function get ($id) {
    return $this->core->fetch(
      "SELECT * FROM `vtables` WHERE `id`=?",
      [$id]
    );
  }

  function add ($id, $data) {
    $created = date('Y-m-d H:i:s');
    return $this->core->exec(
      "INSERT INTO `vtables` (`id`, `opened`, `created`, `updated`, `data`) VALUES (?, ?, ?, ?, ?)",
      [$id, 0, $created, $created, $data]
    );
  }

  function edit ($id, $data) {
    $updated = date('Y-m-d H:i:s');
    return $this->core->exec(
      "UPDATE `vtables` SET `updated`=?, `data`=? WHERE `id`=?",
      [$updated, $data, $id]
    );
  }

  function open ($id, $opened) {
    $updated = date('Y-m-d H:i:s');
    return $this->core->exec(
      "UPDATE `vtables` SET `updated`=?, `opened`=? WHERE `id`=?",
      [$updated, $opened, $id]
    );
  }

  function del ($id) {
    return $this->core->exec(
      "DELETE FROM `vtables` WHERE `id`=?",
      [$id]
    );
  }
}
