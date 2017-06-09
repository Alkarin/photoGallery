<?php
require_once("../../includes/initialize.php");

if($session->is_logged_in()) { redirect_to("index.php"); }

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) {
  // Form has been submitted

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Check database to see if username/password exist

  $found_user = User::authenticate($username, $password);

  if($found_user) {
    $session->login($found_user);
    redirect_to("index.php");
  } else {
    // username/password combo was not found in database
    $message = "Username or password is incorrect.";
  }
} else {
  // Form has not been submitted
  $username = "";
  $password = "";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="../stylesheet/master.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div id="header">
      <h1>Photo Gallery</h1>
    </div>
    <div id="main">
      <h2>Staff Login</h2>
      <?php if(isset($message)){ echo output_message($message); } ?>
      <form class="" action="login.php" method="post">
        <table>
          <tr>
            <td>Username:</td>
            <td>
              <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username);?>">
            </td>
          </tr>
          <tr>
            <td>Password:</td>
            <td>
              <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password);?>">
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Login">
            </td>
          </tr>
        </table>
      </form>
    </div>
    <div id="footer">
      Copyright <?php echo date("Y" , time()); ?>, Alexander Vaughan
    </div>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>
