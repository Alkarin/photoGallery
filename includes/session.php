<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally
// inadvisable to store DB-related objects in sessions
// Because data can become stale

class Session {
  //Session is stored on the server as a file
  //Store user state

  private $logged_in = false;
  public $user_id;

  function __construct(){
    session_start();
    $this->check_login();
  }

  public function is_logged_in(){
    // This way its read only. Cannot write to variable
    return $this->logged_in;
  }

  private function check_login(){
    if(isset($_SESSION['user_id'])){
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }

  public function login($user){
    // database should find user based on username/password
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->logged_in = true;
    }
  }

  public function logout($user){
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
  }

}

$session = new Session();

?>
