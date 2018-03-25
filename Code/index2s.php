<?php 
include "base.php"; 
?>

<?php
if(!empty($_POST['sheltername']) && !empty($_POST['shelterpassword'])){
    $sheltername = $mysqli->real_escape_string($_POST['sheltername']);
    $password = md5($mysqli->real_escape_string($_POST['shelterpassword']));

    // check shelter information in database
    $checklogin = $mysqli->query("SELECT * FROM shelter_account WHERE shelterName = '".$sheltername."' AND password = '".$password."'");
    if($checklogin->num_rows == 1){
        $row = $checklogin->fetch_array(MYSQLI_ASSOC);
        $_SESSION['shelterName'] = $sheltername;
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['AccessLevel'] = $row['accessLevel'];
        $_SESSION['Username'] = "Admin";
        $_SESSION['ShelterID'] = $row['id'];
        echo "<p>Redirect to member area.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=sheltermembers.php\">";
    // redirect back to login page if account not found
    } else {
        echo "<p>No such account. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
    }
    $checklogin->close();
// redirect back to login page if sheltername or password missing
} else {
    echo "<p>Username or password missing. Please try again.</p>";
    echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
}
?>





