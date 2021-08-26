<?php
class Core {
  // (A) PROPERTIES
  public $error = ""; // LAST ERROR MESSAGE
  public $pdo = null; // DATABASE CONNECTION
  public $stmt = null; // SQL STATEMENT
  public $lastID = null; // LAST INSERT/UPDATE ID

  function httpError ($httpStatusCode, $httpStatusMsg) {
    $phpSapiName    = substr(php_sapi_name(), 0, 3);
    if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
        header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
    } else {
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
        header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
    }
  }

  function respond ($OK) {
    if (!empty($OK)) {
      header('HTTP/1.1 200 OK');
      header("Content-Type: application/json;charset=UTF-8");
      echo $this->successAsJson("OK");
    } else {
      header("HTTP/1.1 500 Internal error");
      header("Content-Type: application/json;charset=UTF-8");
      echo $this->errorAsJson();
    }
  }

  function respondJson ($data) {
    if (!empty($data)) {
      header('HTTP/1.1 200 OK');
      header("Content-Type: application/json;charset=UTF-8");
      echo json_encode($data);
    } else {
      header("HTTP/1.1 500 Internal error");
      header("Content-Type: application/json;charset=UTF-8");
      echo $this->errorAsJson();
    }
  }

  function errorMissingValue ($valueName) {
    $this->httpError(400, "missing parameter " . $valueName);
  }

  function errorAsJson () {
    return '{ "error": true, "message": "' . $this->error . '", "context": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" }';
  }

  function successAsJson ($data) {
    return '{ "error": false, "message": "' . $data . '", "context": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" }';
  }

  // (B) LOAD () : LOAD SPECIFIED MODULE
  //  $module : module to load
  function load ($module) {
    // (B1) CHECK IF MODULE IS ALREADY LOADED
    if (isset($this->$module)) { return true; }

    // (B2) EXTEND MODULE ON CORE OBJECT
    $file = PATH_LIB . "lib-$module.php";
    if (file_exists($file)) {
      require $file;
      $this->$module = new $module();
      // EVIL POINTER - ALLOW OBJECTS TO ACCESS EACH OTHER
      $this->$module->core =& $this;
      $this->$module->error =& $this->error;
      $this->$module->pdo =& $this->pdo;
      $this->$module->stmt =& $this->stmt;
      return true;
    } else {
      $this->error = "$file not found!";
      return false;
    }
  }

  // (C) __CONSTRUCT () : CONNECT TO DATABASE
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=". DB_HOST .";port=". DB_PORT .";charset=". DB_CHARSET .";dbname=". DB_NAME,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ]
      );
    } catch (Exception $ex) { exit ($ex->getMessage()); }
  }

  // (D) __DESTRUCT () : CLOSE CONNECTION WHEN DONE
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  // (E) EXEC () : RUN SQL QUERY
  //  $sql : SQL query
  //  $data : array of parameters
  function exec ($sql, $data=null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      $this->lastID = $this->pdo->lastInsertId();
      return true;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }

  // (F) FETCH () : FETCH SINGLE ROW
  //  $sql : SQL query
  //  $data : array of parameters
  function fetch ($sql, $data=null) {
    if (!$this->exec($sql, $data)) { return false; }
    return $this->stmt->fetch();
  }

  // (G) FETCHALL () : FETCH MULTIPLE ROWS
  //  $sql : SQL query
  //  $data : array of parameters
  //  $arrange : (string) arrange by [$ARRANGE] => RESULTS
  //             (array) arrange by [$ARRANGE[0] => $ARRANGE[1]]
  //             (none) default - whatever is set in PDO
  function fetchAll ($sql, $data=null, $arrange=null) {
    // (G1) RUN SQL QUERY
    if (!$this->exec($sql, $data)) { return false; }

    // (G2) FETCH ALL AS-IT-IS
    if ($arrange===null) { return $this->stmt->fetchAll(); }

    // (G3) ARRANGE BY $DATA[$ARRANGE] => RESULTS
    else if (is_string($arrange)) {
      $data = [];
      while ($row = $this->stmt->fetch()) { $data[$row[$arrange]] = $row; }
      return $data;
    }

    // (G4) ARRANGE BY $DATA[$ARRANGE[0]] => $ARRANGE[1]
    else {
      $data = [];
      while ($row = $this->stmt->fetch()) { $data[$row[$arrange[0]]] = $row[$arrange[1]]; }
      return $data;
    }
  }
}
