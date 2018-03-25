<?php 
include "base.php"; 
?>

<!DOCTYPE html>

<head>
    <title>Animal Registration</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    
<div id="main">

<?php

if(!empty($_POST['name']) && !empty($_POST['age'])){
    $name = $mysqli->real_escape_string($_POST['name']);
    $age = ($mysqli->real_escape_string($_POST['age']));
    $gender = $mysqli->real_escape_string($_POST['gender']);
    $breed = $mysqli->real_escape_string($_POST['breed']);
    $species = $mysqli->real_escape_string($_POST['species']);
    $acctCreationDate = date('Y-m-d H:i:s');
    $accessLevel = 0;
    
    $shelterName = $_SESSION['shelterName'];
    $shelterid = $mysqli->query("SELECT id FROM shelter_account WHERE shelterName = '".$shelterName."'"); //grab shelter id from the current session's shelter name
    $row = $shelterid->fetch_array(MYSQLI_ASSOC);
    
    $checkpetname = $mysqli->query("SELECT * FROM pet_account WHERE name = '".$name."'");
    if($checkpetname->num_rows == 1){
        echo "<p>Duplicate pet name. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=sheltermembers.php\">";    
    } else {
        $registerquery = $mysqli->query("INSERT INTO pet_account (name, age, sid, gender, breed, species, acctCreationDate, accessLevel ) VALUES ('".$name."','".$age."','".$row['id']."','".$gender."','".$breed."','".$species."','".$acctCreationDate."','".$accessLevel."')");




        if($registerquery){
            echo "<p>Animal added. </p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=sheltermembers.php\">";    
        } else {
            echo "<p>Failed to register.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=sheltermembers.php\">";    
        }
    }

} 

?>

