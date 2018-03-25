<?php 
include "base.php"; 
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    
    <title>New User Registration</title>

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

<body data-spy="scroll" data-target=".navbar-collapse">

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
if(!empty($_POST['username']) && !empty($_POST['userpassword']) && ($_POST['userpassword'] == $_POST['confirmuserpassword'])){
    // get data to insert into user_account table
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = md5($mysqli->real_escape_string($_POST['userpassword']));
    $firstname = $mysqli->real_escape_string($_POST['userFirstName']);
    $lastname = $mysqli->real_escape_string($_POST['userLastName']);
    $useremail = $mysqli->real_escape_string($_POST['useremail']);
    $acctCreationDate = date('Y-m-d H:i:s');
    $accessLevel = 1;
    $sid = 1;

    // check if user name already taken
    $checkusername = $mysqli->query("SELECT * FROM user_account WHERE userName = '".$username."'");

    if($checkusername->num_rows == 1){
        echo "<p>Username unavailable. Please go back and try again.</p>";
        echo "<meta http-equiv=\"refresh\" content=\"2;URL=registeruser.php\">";
    } else {
        $registerquery = $mysqli->query("INSERT INTO user_account (userName, password, firstName, lastName, email, accessLevel, acctCreationDate, sid) VALUES('".$username."','".$password."','".$firstname."','".$lastname."','".$useremail."','".$accessLevel."','".$acctCreationDate."', '".$sid."')");
        if($registerquery){
            echo "<p>Account created. Please login to continue.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
        } else {
            echo "<p>Failed to register. Please go back and try again.</p>";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL=registeruser.php\">";
        }
    }
// if passwords do not match, do not create account and redirect to reg page
} elseif(!empty($_POST['username']) && !empty($_POST['userpassword']) && ($_POST['userpassword'] != $_POST['confirmuserpassword'])){
    echo "<p>Passwords do not match.  Please try again.</p>";
    echo "<meta http-equiv=\"refresh\" content=\"2;URL=registeruser.php\">";    

// display form
} else {
?>

<!-- CREATE USER ACCOUNT INPUT FORM -->
<form method="post" action="registeruser.php" name="registeriuserform" id="registeruserform" class="basic-grey">
<h1>Register User</h1>
    <label for="username">*Username:</label><input type="text" name="username" id="username" /><br />
    <label for="userpassword">*Password:</label><input type="password" name="userpassword" id="userpassword" /><br />
    <label for="confirmuserpassword">*Confirm Password:</label><input type="password" name="confirmuserpassword" id="confirmuserpassword" /><br />
    <label for="userFirstName">First Name:</label><input type="text" name="userFirstName" id="userFirstName" /><br />
    <label for="userLastName">Last Name:</label><input type="text" name="userLastName" id="userLastName" /><br />
    <label for="useremail">Email address:</label><input type="text" name="useremail" id="useremail" /><br />
    <input type="submit" class="button" name="registeruser" id="registeruser" value="Register" />
</form>

<?php
}
?>

</div>
</body>
</html>


