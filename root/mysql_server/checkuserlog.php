<?php
session_start(); // Start Session First Thing
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', 0);
//-----------------------------------------------------------------------------------------------------------------------------------
include_once "mysql_server/connect_to_mysql.php"; // Connect to the database



/*
 * Facebook Variables
 */

$app_id = '';

$app_secret = '';

$facebook_redirect = "";

require 'functions/bootstrap.php';

require 'config/config.php';

$config = config::get_instance();


$database = $config->get('use_database');

require "databases/" . $database . ".php";

require "databases/crud.php";


$dyn_www = $_SERVER['HTTP_HOST']; // Dynamic www.domainName available now to you in all of your scripts that include this file



//------ CHECK IF THE USER IS LOGGED IN OR NOT AND GIVE APPROPRIATE OUTPUT -------


$logOptions = ''; // Initialize the logOptions variable that gets printed to the page


// If the session variable and cookie variable are not set this code runs

if (!isset($_SESSION['idx'])) { 
  if (!isset($_COOKIE['idCookie'])) {
     $logOptions = '<ul class="headerRightList">
					<li>
						<a href="http://' . $dyn_www . '/register.php">Sign Up Today!</a>
					</li>
					&nbsp;&nbsp; | &nbsp;&nbsp;
					<li>
						<a href="http://' . $dyn_www . '/login.php">Log In</a>
					</li>
				</ul> 	 ';
   }
}



// If session ID is set for logged in user without cookies remember me feature set

if (isset($_SESSION['idx'])) { 
    
	$decryptedID = base64_decode($_SESSION['idx']);
	$id_array = explode("p3h9xfn8sq03hs2234", $decryptedID);
	$logOptions_id = $id_array[1];
	
	// Check if this user has any new PMs and construct which envelope to show
	$sql_pm_check = mysql_query("SELECT id FROM messaging WHERE to_id='$logOptions_id' AND opened='0' LIMIT 1");
	
	$num_new_pm = mysql_num_rows($sql_pm_check);
	
	if ($num_new_pm > 0) {
	
		$PM_envelope = '('.$num_new_pm.')';
		
		$PM_envelope_header = '<a href="inbox.php"><img src="images/header/hover-inbox.png" height="40px" border="0"/></a>';
		
	} else {
	
		$PM_envelope = '('.$num_new_pm.')';
		
		$PM_envelope_header = '<a href="inbox.php" ><img src="images/header/normal-inbox.png" height="40px" border="0"/></a>';
		
	}
	
	
    // Ready the output for this logged in user
    $logOptions = ' <ul class="headerRightList">
					<li>
						<a class="headerHomeLink" href="home.php">Home</a>
					</li>
					&nbsp;&nbsp; | &nbsp;&nbsp;
					<li>
						<a href="http://' . $dyn_www . '/profile.php?id=' . $logOptions_id . '">Profile</a>
					</li>
					&nbsp;&nbsp; | &nbsp;&nbsp;
					<div class="dc">
							<a href="#" onclick="return false">Account &nbsp; <img src="images/darr.gif" width="10" height="5" alt="Account Options" border="0"/></a>
						<ul>
							<li><a href="http://' . $dyn_www . '/edit_profile.php">Account Options</a></li>
							<li><a href="http://' . $dyn_www . '/inbox.php">Inbox '.$PM_envelope.'</a></li>
							<li><a href="http://' . $dyn_www . '/help.php">Help</a></li>
							<li><a href="http://' . $dyn_www . '/logout.php">Log Out</a></li>
						</ul>
					</div>
				</ul> ';
    
} else if (isset($_COOKIE['idCookie'])) {// If id cookie is set, but no session ID is set yet, we set it below and update stuff
	
	$decryptedID = base64_decode($_COOKIE['idCookie']);
	$id_array = explode("nm2c0c4y3dn3727553", $decryptedID);
	$userID = $id_array[1]; 
	$userPass = $_COOKIE['passCookie'];
	// Get their user first name to set into session var
    $sql_uname = mysql_query("SELECT * FROM myMembers WHERE id='$userID' AND password='$userPass' LIMIT 1");
	$numRows = mysql_num_rows($sql_uname);
	if ($numRows == 0) {
		// Kill their cookies and send them back to homepage if they have cookie set but are not a member any longer
		setcookie("idCookie", '', time()-42000, '/');
	    setcookie("passCookie", '', time()-42000, '/');
		header("location: welcome.php"); // << makes the script send them to any page we set
		exit();
	}
    while($row = mysql_fetch_array($sql_uname)){

    	if($row = mysql_fetch_array($sql_uname)){

	   		extract($sql_uname);
	   		
		} else 

			?><script>location.reload();</script><?php
			echo $sql_uname;
			header("refresh: 0;");
	}

    $_SESSION['id'] = $userID; // now add the value we need to the session variable
	$_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$userID");
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
	$_SESSION['email'] = $useremail;
	$_SESSION['password'] = $userpass;

    
    ///////////          Update Last Login Date Field       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    mysql_query("UPDATE myMembers SET last_log_date=now() WHERE id='$logOptions_id'"); 
    // Ready the output for this logged in user
   
	
	// Ready the output for this logged in user
     $logOptions = '<ul class="headerRightList">
					<li>
						<a class="headerHomeLink" href="home.php">Home</a>
					</li>
					<li>
						<a href="http://' . $dyn_www . '/profile.php?id=' . $logOptions_id . '">Profile</a>
					</li>
					
					<div class="dc">
							<a href="#" onclick="return false">Account &nbsp; <img src="images/darr.gif" width="5" height="5" alt="Account Options" border="0"/></a>
						<ul>
							<li><a href="http://' . $dyn_www . '/edit_profile.php">Account Options</a></li>
							<li><a href="http://' . $dyn_www . '/inbox.php">Inbox '.$PM_envelope.'</a></li>
							<li><a href="http://' . $dyn_www . '/help.php">Help</a></li>
							<li><a href="http://' . $dyn_www . '/logout.php">Log Out</a></li>
						</ul>
					</div>
				</ul> ';
}
?>