<?php
include "base.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Member area</title>

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
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){  
?>
    <h1>User Area</h1>
   

<form method="post" action="edituserprofile.php" class="basic-grey">
<?php
    echo "<h1>View/Edit Profile for user ".$_SESSION['Username']."</h1>\n";
?>
<?php
    $stmt = $mysqli->prepare("SELECT id, userName, firstName, lastName, email, acctCreationDate from user_account WHERE userName = '". $_SESSION['Username']."'");    
    $stmt->execute();
    $stmt->bind_result($id, $username, $firstName, $lastName, $email, $acctCreation);
    while($stmt->fetch()){
    echo " <input type='hidden' name='id' value='".$id."' />\n"
        ."<label>Username: ".$username."</label><br />\n"
        ."<label for='firstName'>First Name:</label><input type='text' name='firstName' value='". $firstName ."' /><br />\n"
        ."<label for='lastName'>Last Name:</label><input type='text' name='lastName' value='". $lastName ."' /><br />\n"
        ."<label for='email'>Email:</label><input type='text' name='email' value='". $email ."' /><br />\n"
        ."<label>Account created: ".$acctCreation."</label><br />\n"
        ."<input type='submit' class='button' name='update' value='Update' />";
    }     
    $stmt->close();

?>
</form>

<!-- TODO: Save animal/shelter preferences -->


<!-- TODO: Search for animals -->


<!-- TODO: Schedule animal time -->


<!-- TODO: Delete own account? -->


<?php
} else {
?>
    <h1> Not logged in</h1>

<?php
}
?>





</div>
</body>
</html>
