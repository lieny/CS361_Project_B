<?php
include "base.php";

echo '<meta http-equiv="refresh" content="2;URL=\'sheltermembers.php\'">';

$firstname = $mysqli->real_escape_string($_POST['firstname']);
$lastname = $mysqli->real_escape_string($_POST['lastname']);
$email = $mysqli->real_escape_string($_POST['email']);
$permissioncode = md5($mysqli->real_escape_string($_POST['permissioncode']));
$sid = $_POST['id'];

$stmt = $mysqli->prepare("UPDATE shelter_account SET firstName=?, lastName=?, email=?, permissionCode=? WHERE id=?");
$stmt->bind_param("ssssi",$firstname,$lastname,$email,$permissioncode,$sid);
$stmt->execute();

?>
