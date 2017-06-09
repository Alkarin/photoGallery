<?php
// If class needs the database, we should require it before we start
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {

  protected static $table_name = "users";
  // attribute for each column in users DB table
  // User class->object is essentially a record from the DB table
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;

  public static function authenticate($username="", $password=""){

    // Passwords are NOT encrypted
    // Should implement later w/ salting
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";

    $result_array = self::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public function full_name(){
    if(isset($this->first_name) && isset($this->last_name)){
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }
}
?>
