<?php
// If class needs the database, we should require it before we start
require_once('database.php');

class User {

  // attribute for each column in users DB table
  // User class->object is essentially a record from the DB table
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;

  public static function find_all(){
    global $database;
    $result_set = self::find_by_sql("SELECT * FROM users");
    return $result_set;
  }

  public static function find_by_id($id=0){
    global $database;
    $result_array = self::find_by_sql("SELECT * FROM users WHERE id={$id} LIMIT 1");
    // if array is not empty, return first object in array, else return false
    // array_shift pulls first element out of the array
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_sql($sql=""){
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while($row = $database->fetch_array($result_set)){
      $object_array[] = self::instantiate($row);
    }
    // return an array of objects
    // $rows and raw result set will NOT be passed back to index, just recieve objects instead
    return $object_array;
  }

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

  private static function instantiate($record){
    // builds user object from record
    // Could check that $record exists and is an array

    // Needed for both approaches
    $object = new self();

    // Simple, long-form approach:
    // $object->id         = $record['id'];
    // $object->username   = $record['username'];
    // $object->password   = $record['password'];
    // $object->first_name = $record['first_name'];
    // $object->last_name  = $record['last_name'];

    // More dynamic, short-form apporach
    foreach ($record as $attribute => $value) {
      if($object->has_attribute($attribute)){
        // why do both need $ ??
        // maybe because $attribute is not a specifically defined, its a variable
        $object->$attribute = $value;
      }
    }
    return $object;
  }

  private function has_attribute($attribute){
    // get_object_vars returns an associative array with all attributes
    // (including private ones) as the keys and their current values as the value
    $object_vars = get_object_vars($this);

    // We don't care about the value, we just want to know if the key exists
    // does $attribute(key) exist in $object_vars
    // Will return true or false
    return array_key_exists($attribute, $object_vars);

  }
}
?>
