<?php 
include "base.php"; 
?>

<?php
//} 
if(!empty($_POST['username']) && !empty($_POST['userpassword'])){
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = md5($mysqli->real_escape_string($_POST['userpassword']));

    // look up user in database
    $checklogin = $mysqli->query("SELECT * FROM user_account WHERE userName = '".$username."' AND password = '".$password."'");
    if($checklogin->num_rows == 1){
        $row = $checklogin->fetch_array(MYSQLI_ASSOC);
        $_SESSION['Username'] = $username;
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['AccessLevel'] = $row['accessLevel'];
        echo "<p>Redirect to member area.</p>";

        // if user is a shelter employee redirect to shelter member page
        if($row['sid'] && ($row['accessLevel'] >= 5)){
            $shelter = $mysqli->query("SELECT shelterName FROM shelter_account WHERE id='".$row['sid']."'");
            $shelter = $shelter->fetch_array(MYSQLI_ASSOC);
            $_SESSION['shelterName'] = $shelter['shelterName'];
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=sheltermembers.php\">";
        // otherwise regular user page
        } else {
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=members.php\">";
        }
    } else {
        echo "<p>No such account. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
    }
    $checklogin->close();
// redirect to login if missing username or password
} else {
    echo "<p>Username or password missing. Please try again.</p>";
    echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
}
?>





