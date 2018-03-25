<?php
include "base.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Shelter Member area</title>




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
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['shelterName'])){
    echo "<p><a href=\"delete_acct_index.php\">DELETE ACCOUNTS</a></p>";

    if($_SESSION['AccessLevel'] == 10){
?>
<h2>Shelter Admin Functions</h2>
<form method="post" action="editshelterprofile.php" class="basic-grey">
        <h1>View/edit shelter information</h1>
<?php        
    $stmt = $mysqli->prepare("SELECT id, shelterName, firstName, lastName, email, acctCreationDate FROM shelter_account WHERE shelterName='".$_SESSION['shelterName']."'");
    $stmt->execute();
    $stmt->bind_result($id,$sheltername,$firstname,$lastname,$email,$acctCreation);
    while($stmt->fetch()){
    echo "<input type='hidden' name='id' value='".$id."' />\n"
        ."<label>Shelter Name: ".$sheltername."</label><br />\n"
        ."<label for='firstname'>First Name:</label><input type='text' name='firstname' value='".$firstname."' /><br />\n"
        ."<label for='lastname'>Last Name:</label><input type='text' name='lastname' value='".$lastname."' /><br />\n"
        ."<label for='email'>Email:</label><input type='text' name='email' value='".$email."' /><br />\n"
        ."<label for='permissioncode'>Permission Code:</label><input type='text' name='permissioncode' /><br />\n"
        ."<label>Account created: ".$acctCreation."</label><br />\n"
        ."<input type='submit' class='button' name='update' value='Update' />";
        
    }
    $stmt->close(); 
?>
</form>

<!-- View staff for this shelter -->
<?php
    $qry = $mysqli->query("SELECT * FROM user_account WHERE sid='".$_SESSION['ShelterID']."'");
    if($qry->num_rows > 0){
?>
<br>
<table class="basic-grey">
<caption>Staff</caption>
<thead>
<tr>
    <th>Username</th>
    <th>Name</th>
    <th>Email</th>
    <th>Access</th>
    <th>Acct Created</th>
</tr>
</thead>
<tbody>
<?php 
    $stmt = $mysqli->prepare("SELECT firstName,lastName,email,userName,accessLevel,acctCreationDate FROM user_account WHERE sid='".$_SESSION['ShelterID']."'");
    $stmt->execute();
    $stmt->bind_result($staffFirstName,$staffLastName,$staffEmail,$staffUsername,$staffAccess,$staffCreation);
    while($stmt->fetch()){     
        echo "<tr><td>".$staffUsername."</td><td>".$staffFirstName." ".$staffLastName."</td><td>".$staffEmail."</td><td>".$staffAccess."</td><td>".$staffCreation."</td></tr>\n";
    }
    $stmt->close();
?>
</tbody>
</table>
<?php
}
?>

<!-- TODO: Remove staff? -->

<?php        
    }
    if($_SESSION['AccessLevel'] >= 5){
        echo "<h2>Staff functions for ".$_SESSION['Username']." at ".$_SESSION['shelterName']."</h2>";
?>

<form method="post" action="reganimal.php" name="reganimalform" id="reganimalform" class="basic-grey">
    <h1>Add new animal information</h1>
    <label for="name">Name:</label><input type="text" name="name" id="name" /><br />
    <label for="age">Age:</label><input type="text" name="age" id="age" /><br />
    <label for="gender">Gender:</label><input type="text" name="gender" id="gender" /><br />
    <label for="species">Species:</label><input type="text" name="species" id="species" /><br />
    <label for="breed">Breed:</label><input type="text" name="breed" id="breed" /><br />
<input type="submit" class="button" name="reganimal" id="reganimal" />

</form>
<!-- TODO: View/search animals for this shelter -->


<!-- TODO: Update animals' schedule -->


<!-- TODO: View schedule for this shelter's animals-->


<!-- TODO: Remove animals from shelter? -->


<!-- Update non-admin user profile-->
<?php
if (($_SESSION['AccessLevel'] < 10) && ($_SESSION['AccessLevel'] > 0)){
?>
<br />
<form method="post" action="edituserprofile.php" class="basic-grey">
        <h1>View/edit user information</h1>
<?php        
    $stmt = $mysqli->prepare("SELECT id, userName, firstName, lastName, email, acctCreationDate FROM user_account WHERE userName='".$_SESSION['Username']."'");
    $stmt->execute();
    $stmt->bind_result($uid,$username,$ufirstname,$ulastname,$uemail,$uacctCreation);
    while($stmt->fetch()){
    echo "<input type='hidden' name='id' value='".$uid."' />\n"
        ."<label>Username: ".$username."</label><br />\n"
        ."<label for='firstName'>First Name:</label><input type='text' name='firstName' value='".$ufirstname."' /><br />\n"
        ."<label for='lastName'>Last Name:</label><input type='text' name='lastName' value='".$ulastname."' /><br />\n"
        ."<label for='email'>Email:</label><input type='text' name='email' value='".$uemail."' /><br />\n"
        ."<label>Account created: ".$uacctCreation."</label><br />\n"
        ."<input type='submit' class='button' name='update' value='Update' />";
        
    }
    $stmt->close(); 
?>
</form>
<?php
}
?>
<?php 
    } else {
        echo "<p>Insufficient access level.</p>";
    }
} else {
?>
<p>Not logged in</p>
<?php
echo "<meta http-equiv=\"refresh\" content=\"2;URL=index1.php\">";
}
?>




</div>
</body>
</html>
