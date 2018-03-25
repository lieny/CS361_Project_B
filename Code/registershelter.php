<?php 
/* Send verification email
** https://code.tutsplus.com/tutorials/how-to-implement-email-verification-for-new-members--net-3824
*/
include "base.php"; 
?>

<!DOCTYPE html>
<head>
    <title>New Shelter Registration</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Stylesheet CSS -->
    <link rel="stylesheet" href="style.css" type="text/css"/>

</head>

<body>


    <!-- navigation -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                    <span class="icon icon-bar"></span>
                </button>
                <a href="#home" class="navbar-brand smoothScroll">Navigation</a>
            </div>
            
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="home.php" class="smoothScroll">HOME</a></li>
<!--$_SESSION['AccessLevel'] = $row['accessLevel'];-->

<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION['AccessLevel'] >= 5){  ?>

                    <li><a href="logout.php" class="smoothScroll">LOGOUT</a></li>
                    <li><a href="sheltermembers.php" class="smoothScroll">MEMBERS</a></li>

<?php }else if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION['AccessLevel'] <= 1){ ?>


                    <li><a href="logout.php" class="smoothScroll">LOGOUT</a></li>
                    <li><a href="members.php" class="smoothScroll">MEMBERS</a></li>

<?php }else{ ?>
                    <li><a href="index1.php" class="smoothScroll">LOGIN</a></li>
<?php } ?>
                    <li><a href="registeruser.php" class="smoothScroll">REGISTER</a></li>
                    <li><a href="search_index.php" class="smoothScroll">SEARCH</a></li>
                    <li><a href="calender.php" class="smoothScroll">CALENDER</a></li>
                    <li><a href="contact.php" class="smoothScroll">CONTACT</a></li>
                </ul>
            </div>
        </div>
    </div> 


<div id="main">
<?php

// form posted with required information
if(!empty($_POST['sheltername']) && !empty($_POST['shelterpassword']) && ($_POST['shelterpassword'] == $_POST['confirmshelterpassword'])){
    // basic check for valid email address
    $shelteremail = $mysqli->real_escape_string($_POST['shelteremail']);
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $shelteremail)){
        echo "<p>Invalid email address. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=registershelter.php\">";
    } else {
        // get data to insert into shelter_account table
        $username = $mysqli->real_escape_string($_POST['sheltername']);
        $password = md5($mysqli->real_escape_string($_POST['shelterpassword']));
        $firstname = $mysqli->real_escape_string($_POST['shelterFirstName']);
        $lastname = $mysqli->real_escape_string($_POST['shelterLastName']);
        $permissioncode = md5($mysqli->real_escape_string($_POST['permissionCode']));
        $acctCreationDate = date('Y-m-d H:i:s');
        $accessLevel = 0;

        // check if shelter name already has an account 
        $checkusername = $mysqli->query("SELECT * FROM shelter_account WHERE shelterName = '".$username."'");
        if($checkusername->num_rows == 1){
            echo "<p>Shelter name unavailable. Please try again.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=registershelter.php\">";
        // if not, insert data into table
        } else {
            $registerquery = $mysqli->query("INSERT INTO shelter_account (shelterName, password, firstName, lastName, email, permissionCode, accessLevel, acctCreationDate) VALUES('".$username."','".$password."','".$firstname."','".$lastname."','".$shelteremail."','".$permissioncode."','".$accessLevel."','".$acctCreationDate."')");
            if($registerquery){
                // send verification email to change access level            
                $to = $shelteremail;
                $subject = "Shelter account verification";
                $message = "Account " . $username . " has been created.\n"
                            ."Click this link to access shelter privileges\n"
                            .$dburl."verify.php?sheltername=".urlencode($username)."&email=".$shelteremail."&permissionCode=".$permissioncode;
                $headers = "From:".$fromemail."\r\n";
                mail($to, $subject, $message, $headers);

                echo "<p>Account created. Check email to verify account and activate shelter account privileges.</p>";
                echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
            } else {
                echo "<p>Error creating account.</p>";
                echo "<meta http-equiv=\"refresh\" content=\"2;URL=registershelter.php\">";
            }
        }
    }
// if passwords do not match, do not create account and redirect to registration page
} elseif(!empty($_POST['sheltername']) && !empty($_POST['shelterpassword']) && ($_POST['shelterpassword'] != $_POST['confirmshelterpassword'])){
        echo "<p>Passwords do not match. Try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=registershelter.php\">";

// if form not yet submitted, display form
} else {
?>

<!-- CREATE SHELTER ACCOUNT INPUT FORM -->
<form method="post" action="registershelter.php" name="registerform" id="registerform" class="basic-grey">
<h1>Register New Shelter</h1>
<fieldset>
    <legend>Shelter Information</legend>
    <label for="sheltername">*Sheltername:</label><input type="text" name="sheltername" id="sheltername" required /><br />
    <label for="shelterpassword">*Password:</label><input type="password" name="shelterpassword" id="shelterpassword" required /><br />
    <label for="confirmshelterpassword">*Confirm Password:</label><input type="password" name="confirmshelterpassword" id="confirmshelterpassword" required /><br />
    <label for="permissionCode">Permission Code (to enable staff access):</label><input type="text" name="permissionCode" id="permissionCode" /><br />
</fieldset>
<br />
<fieldset>
    <legend>Shelter Administrator Information</legend>
    <label for="shelteremail">*Email address:</label><input type="text" name="shelteremail" id="shelteremail" required /><br />
    <label for="shelterFirstName">First Name:</label><input type="text" name="shelterFirstName" id="shelterFirstName" /><br />
    <label for="shelterLastName">Last Name:</label><input type="text" name="shelterLastName" id="shelterLastName" /><br />
</fieldset>
<br />
    <input type="submit" class="button" name="registershelter" id="registershelter" value="Register" />
</form>

<?php
}
?>

</div>
</body>
</html>


