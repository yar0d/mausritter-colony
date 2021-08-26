<?php
class User {
  // (A) GETALL () : GET ALL USERS
  function getAll () {
    return $this->core->fetchAll(
      "SELECT * FROM `users`", null, "user_id"
    );
  }

  // (B) GET () : GET USER BY ID OR EMAIL
  //  $id : user ID or email
  function get ($id) {
    return $this->core->fetch(
      "SELECT * FROM `users` WHERE `user_". (is_numeric($id)?"id":"email") ."`=?",
      [$id]
    );
  }

  // (C) ADD () : ADD A NEW USER
  function add ($name, $email) {
    // (C1) CHECK IF ALREADY REGISTERED
    $check = $this->get($email);
    if (is_array($check)) {
      $this->error = "$email is already registered!";
      return false;
    }

    // (C2) PROCEED ADD
    return $this->core->exec(
      "INSERT INTO `users` (`user_name`, `user_email`) VALUES (?, ?)",
      [$name, $email]
    );
  }

  // (D) EDIT () : UPDATE AN EXISTING USER
  function edit ($name, $email, $id) {
    return $this->core->exec(
      "UPDATE `users` SET `user_name`=?, `user_email`=? WHERE `user_id`=?",
      [$name, $email, $id]
    );
  }

  // (E) DEL () : DELETE USER
  function del ($id) {
    return $this->core->exec(
      "DELETE FROM `users` WHERE `user_id`=?",
      [$id]
    );
  }
}