<?php
include "base.php";

if($_SESSION['AccessLevel'] >= 5){
    echo '<meta http-equiv="refresh" content="2;URL=\'sheltermembers.php\'">';
} else {
    echo '<meta http-equiv="refresh" content="2;URL=\'members.php\'">';
}

$stmt = $mysqli->prepare("UPDATE user_account SET firstName=?, lastName=?, email=? WHERE id=?");
$stmt->bind_param("sssi",$_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['id']);
$stmt->execute();

?>


