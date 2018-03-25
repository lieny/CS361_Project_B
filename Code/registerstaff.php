<?php 
include "base.php"; 
?>

<!DOCTYPE html>
<head>
    <title>New Shelter Staff Registration</title>


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
    <link rel="stylesheet" href="style.css" type="text/css" />
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
if(!empty($_POST['username']) && !empty($_POST['password']) && ($_POST['password'] == $_POST['confirmpassword'])){
    // get data to insert into shelter_account table
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = md5($mysqli->real_escape_string($_POST['password']));
    $firstname = $mysqli->real_escape_string($_POST['firstName']);
    $lastname = $mysqli->real_escape_string($_POST['lastName']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $permissioncode = md5($mysqli->real_escape_string($_POST['permissionCode']));
    $acctCreationDate = date('Y-m-d H:i:s');
    $accessLevel = 0;
    $sid = $_POST['shelter'];

    // check if shelter name already has an account 
    $checkusername = $mysqli->query("SELECT * FROM user_account WHERE userName = '".$username."'");
    if($checkusername->num_rows == 1){
        echo "<p>Username unavailable. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=registerstaff.php\">";

    // if all ok, insert data into table
    } else {
        // check for shelter/permission code
        $checkshelter = $mysqli->query("SELECT id, permissionCode FROM shelter_account WHERE id='".$sid."' AND permissionCode='".$permissioncode."'");
        if($checkshelter->num_rows != 1){
            echo "<p>Incorrect shelter information. Please contact administrator for correct permissioncode.</p>";
            //echo "<meta http-equiv=\"refresh\" content=\"2;URL=registerstaff.php\">";
        } else {
            $accessLevel = 5;
        }
        $registerquery = $mysqli->query("INSERT INTO user_account (userName, password, firstName, lastName, email, accessLevel, acctCreationDate, sid) VALUES('".$username."','".$password."','".$firstname."','".$lastname."','".$email."','".$accessLevel."','".$acctCreationDate."','".$sid."')");
        if($registerquery){
            echo "<p>Account created. Please login to continue.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
        } else {
            echo "<p>Error creating account.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=registerstaff.php\">";
        }
    }

// if passwords do not match, do not create account and redirect to registration page
} elseif(!empty($_POST['sheltername']) && !empty($_POST['shelterpassword']) && ($_POST['shelterpassword'] != $_POST['confirmshelterpassword'])){
        echo "<p>Passwords do not match. Please try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=registerstaff.php\">";

// if form not yet submitted, display form
} else {
?>

<!-- CREATE STAFF ACCOUNT INPUT FORM -->
<form method="post" action="registerstaff.php" name="registerform" id="registerform" class="basic-grey">
<h1>Register Shelter Staff</h1>
<fieldset>
    <legend>Shelter Information</legend>
    <label for="username">*Username:</label><input type="text" name="username" id="username" required /><br />
    <label for="password">*Password:</label><input type="password" name="password" id="password" required /><br />
    <label for="confirmpassword">*Confirm Password:</label><input type="password" name="confirmpassword" id="confirmpassword" required /><br />
    <label for="email">Email address:</label><input type="text" name="email" id="email" /><br />
    <label for="firstName">First Name:</label><input type="text" name="firstName" id="firstName" /><br />
    <label for="lastName">Last Name:</label><input type="text" name="lastName" id="lastName" /><br />
</fieldset>
<br />
<fieldset>
    <label for="shelter">Shelter Affiliation:</label><select name="shelter" id="shelter">
<?php
    // populate dropdown
    $stmt = $mysqli->prepare("SELECT id, shelterName FROM shelter_account ORDER BY shelterName");
    $stmt->execute();
    $stmt->bind_result($shelterid, $sheltername);
    while($stmt->fetch()){
        echo "<option value='".$shelterid."'>".$sheltername."</option>";
    }
    $stmt->close;
?>
    </select><br />
    <label for="permissionCode">Permission Code:</label><input type="text" name="permissionCode" id="permissionCode" /><br />
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


