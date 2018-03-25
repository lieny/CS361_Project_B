<?php

include "base.php";
?>

<!DOCTYPE html>
<head>
    <title>New Shelter Registration</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php

// get data from email verification link
// https://code.tutsplus.com/tutorials/how-to-implement-email-verification-for-new-members--net-3824
if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['permissionCode']) && !empty($_GET['permissionCode']) && isset($_GET['sheltername']) && !empty($_GET['sheltername'])){
    // verify shelter data in database
    $sheltername = $mysqli->real_escape_string($_GET['sheltername']);
    $email = $mysqli->real_escape_string($_GET['email']);
    $permissioncode = $mysqli->real_escape_string($_GET['permissionCode']);

    $search = $mysqli->query("SELECT shelterName, email, permissionCode FROM shelter_account WHERE shelterName='".$sheltername."' AND email='".$email."' AND permissionCode='".$permissioncode."'");

    // if successful update access level for that shelter
    if($search->num_rows == 1){
        $mysqli->query("UPDATE shelter_account SET accessLevel=10 WHERE shelterName='".$sheltername."' AND email='".$email."' AND permissionCode='".$permissioncode."'");
        echo "<p>Shelter privileges have been activated.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";

    } else {
        echo "<p>Activation error.</p>";
    }
}

?>

</div>
</body>
</html>
