<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template('header.php'); ?>

<?php
$user = User::find_by_id(1);
echo $user->full_name();
echo "<hr>";

// 'ctrl + /' to multi-line comment TIL!

$users = User::find_all();
foreach ($users as $user) {
  echo "User: " . $user->username . "<br>";
  echo "Name: " . $user->full_name() . "<br><br>";
}
?>

<?php include_layout_template('footer.php'); ?>
