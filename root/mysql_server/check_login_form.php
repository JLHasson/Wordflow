<?php
// Start Session to enable creating the session variables below when they log in
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '0');
//-----------------------------------------------------------------------------------------------------------------------------------
// Initialize some vars
$errorMsg = '';
$email = '';
$pass = '';
$remember = '';
if ($_GET['attempt'] == 5) {
	header("location: http://word-flow.com");
}

if ($_GET['attempt']) {
	$errorMsg = "Incorrect login data, please try again";
}

if (isset($_POST['email'])) {
	
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	if (isset($_POST['remember'])) {
		$remember = $_POST['remember'];
	}
	$email = stripslashes($email);
	$pass = stripslashes($pass);
	$email = strip_tags($email);
	$pass = strip_tags($pass);
	
	// error handling conditional checks go here
	if ((!$email) || (!$pass)) { 

		$errorMsg = 'Please fill in both fields';

	} else { // Error handling is complete so process the info if no errors
		include 'mysql_server/connect_to_mysql.php'; // Connect to the database
		$email = mysql_real_escape_string($email); // After we connect, we secure the string before adding to query
	    //$pass = mysql_real_escape_string($pass); // After we connect, we secure the string before adding to query
		$pass = md5($pass); // Add MD5 Hash to the password variable they supplied after filtering it
		// Make the SQL query
        $sql = mysql_query("SELECT * FROM myMembers WHERE email='$email' AND password='$pass' AND email_activated='1'"); 
		$login_check = mysql_num_rows($sql);
        // If login check number is greater than 0 (meaning they do exist and are activated)
		if($login_check > 0){ 
    			while($row = mysql_fetch_array($sql)){
					
					// Create session var for their raw id
					$id = $row["id"];   
					$_SESSION['id'] = $id;
					// Create the idx session var
					$_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$id");
					// Create session var for their email
					$useremail = $row["email"];
					$_SESSION['useremail'] = $useremail;
					// Create session var for their password
					$userpass = $row["password"];
					$_SESSION['userpass'] = $pass;

					mysql_query("UPDATE myMembers SET last_log_date=now() WHERE id='$id' LIMIT 1");
        
    			} // close while
	
    			// Remember Me Section
    			if($remember == "yes"){
                    $encryptedID = base64_encode("g4enm2c0c4y3dn3727553$id");
    			    setcookie("idCookie", $encryptedID, time()+60*60*24*100, "/"); // Cookie set to expire in about 30 days
			        setcookie("passCookie", $pass, time()+60*60*24*100, "/"); // Cookie set to expire in about 30 days
    			} 
    			// All good they are logged in, send them to homepage then exit script
				$_SESSION['loggedin'] = true;
				$_SESSION['currentUser'] = $_SESSION['id'];
    			header("location: home.php"); 
    			exit();
	
		} else { // Run this code if login_check is equal to 0 meaning they do not exist
			$attempt = $_GET['attempt'] + 1;
			header("location: http://word-flow.com/login.php?attempt=".$attempt);
		}


    } // Close else after error checks

} //Close if (isset ($_POST['uname'])){

?>