<?php 
/* User login with membership areas:
** https://code.tutsplus.com/tutorials/user-membership-with-php--net-1523 
*/
include "base.php"; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    
    <title>Shelter Account Login</title>


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

    <form method="post" action="index2u.php" name="userloginform" id="userloginform" class="basic-grey">
    <h1>User login
    <span> Login below or register <a href="registeruser.php">user</a> or <a href="registerstaff.php">shelter staff</a>.</span>
    </h1>
        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
        <label for="userpassword">Password:</label><input type="password" name="userpassword" id="userpassword" /><br />
        <input type="submit" class="button" name="userlogin" id="userlogin" value="Login" />
    </form>
<br />
    <form method="post" action="index2s.php" name="shelterloginform" id="shelterloginform" class="basic-grey">
    <h1>Shelter login
    <span> Login below or register <a href="registershelter.php">shelter account</a>.</span>
    </h1>
        <label for="sheltername">Sheltername:</label><input type="text" name="sheltername" id="sheltername" /><br />
        <label for="shelterpassword">Password:</label><input type="password" name="shelterpassword" id="shelterpassword" /><br />
        <input type="submit" class="button" name="shelterlogin" id="shelterlogin" value="Login" />
    </form>


<!-- TODO: Public search -->



</div>
</body>
</html>


