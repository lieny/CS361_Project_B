<?php
include "base.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta charset="utf-8">
		<title>Delete Account</title>


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
 		<style>
		input[type=text], select {
    		width: 180px;
   	 	padding: 12px 20px;
	    	margin: 8px 0;
	    	display: inline-block;
	    	border: 1px solid #ccc;
 	   	border-radius: 4px;
 	   	box-sizing: border-box;
		}

		input[type=submit] {
 	   	width: 120px;
 	   	background-color: #E27575;
  	  	color: white;
  	  	padding: 14px 20px;
  	  	margin: 8px 0;
  	  	border: none;
  	  	border-radius: 4px;
  	  	cursor: pointer;
		}

		input[type=submit]:hover {
   	 	background-color: #ffc0cb;
		}
		</style>

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
        <form class="form-horizontal" method="post" action="delete_pet_acct.php">  
            <fieldset class="border">
                <legend>Delete a Pet Account</legend>
                <select name="petName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT id, name FROM pet_account"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($pid, $pname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $pid . ' "> ' . $pname . '</option>\n';
		}
		$stmt->close();
		?>  
                </select>
            	
		<p><input type="submit" name="submit" value="Delete "></p>
    	 </fieldset>
        
     	</form>       
    </div> 
    
    <div id="main">
        <form class="form-horizontal" method="post" action="delete_user_acct.php">  
            <fieldset class="border">
                <legend>Delete a User Account</legend>
                <select name="userName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT id, userName FROM user_account"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($uid, $uname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $uid . ' "> ' . $uname . '</option>\n';
		}
		$stmt->close();
		?>  
                </select>
            	
		<p><input type="submit" name="submit" value="Delete "></p>
    	 </fieldset>
        
     	</form>       
    </div> 

    <div id="main">
        <form class="form-horizontal" method="post" action="delete_staff_acct.php">  
            <fieldset class="border">
                <legend>Delete a Staff Account</legend>
                <select name="staffName">
                <?php
		if(!($stmt = $mysqli->prepare("SELECT id, firstName FROM shelter_account"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		if(!$stmt->bind_result($sid, $sname)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		while($stmt->fetch()){
			echo '<option value=" '. $sid . ' "> ' . $sname . '</option>\n';
		}
		$stmt->close();
		?>  
                </select><br>

		<p><input type="submit" name="submit" value="Delete "></p>
    	 </fieldset>
        
     	</form>       
    </div> 



    </body>
</html>