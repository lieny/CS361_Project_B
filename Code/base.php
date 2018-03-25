<?php 
	// Turn on error reporting
	ini_set('display_errors','On');
	ini_set('session.save_path',getcwd(). '/');
    session_start();
	// connect to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "xxxx-db","db-pass","xxxx-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno." ".$mysqli->connect_error;
        exit();
    }
    $mysqli->set_charset("utf8");
    $dburl = "http://web.engr.oregonstate.edu/~xxxx/361/";
    $fromemail = "xxxxx@oregonstate.edu";
?>

