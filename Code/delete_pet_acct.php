<?php
include "base.php";
	
if(!($stmt = $mysqli->prepare("DELETE FROM pet_account WHERE id=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("i",$_POST['petName']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Removed " . $stmt->affected_rows . " row from Pet Account.";
}
?>