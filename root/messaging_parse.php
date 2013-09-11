<?php
session_start();
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////                ERROR HANDLING AND LOW LEVEL SECURITY CHECKS                      //////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// RIGHT NOW THERE ARE SOME ISSUES WITH THE SECURITY BUT IM SURE 100% YET //


// else if session id IS NOT EQUAL TO the posted variable for sender ID
//if ($_SESSION['id'] != $_POST['from_id']) {
//	echo  '<img src="../../images/error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>Forged submission</strong>';
//   exit();
//}

require_once "mysql_server/connect_to_mysql.php"; // <<---- Require connection to database here

// PREVENT DOUBLE POSTS /////////////////////////////////////////////////////////////////////////////
$checkuserid = $_POST['from_id'];
$prevent_dp = mysql_query("SELECT id FROM messaging WHERE from_id='$checkuserid' AND time_sent between subtime(now(),'0:0:20') and now()");
$nr = mysql_num_rows($prevent_dp);
if ($nr > 0){
	echo '<img src="images/error.png" alt="Error" width="31" height="30" /> &nbsp;  You must wait 20 seconds between your private message sending.';
	exit();
}
//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////                                                    PARSE THE MESSAGE                                                 //////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Process the message once it has been sent 
if (isset($_POST['message'])) { 
  // Escape and prepare our variables for insertion into the database 
  $to   = ($_POST['recID']); 
  $from = ($_POST['senderID']); 
  $toName   = ($_POST['recName']); 
  $fromName = ($_POST['senderName']); 
  $sub = htmlspecialchars($_POST['subject']); // Convert html tags and such to html entities which are safer to store and display
  $msg = htmlspecialchars($_POST['message']); // Convert html tags and such to html entities which are safer to store and display
  $sub  = mysql_real_escape_string($sub); // Just in case anything malicious is not converted, we escape those characters here
  $msg  = mysql_real_escape_string($msg); // Just in case anything malicious is not converted, we escape those characters here
  // Handle all pm form specific error checking here 
  if (empty($to) || empty($from) || empty($sub) || empty($msg)) { 
    echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  Missing Data to continue';
	exit();
  } else { 
		// Delete the message residing at the tail end of their list so they cannot archive more than 100 PMs ------------------
        $sqldeleteTail = mysql_query("SELECT * FROM messaging WHERE to_id='$to' ORDER BY time_sent DESC LIMIT 0,100"); 
        $dci = 1;
        while($row = mysql_fetch_array($sqldeleteTail)){ 
                $pm_id = $row["id"];
				if ($dci > 99) {
					$deleteTail = mysql_query("DELETE FROM messaging WHERE id='$pm_id'"); 
				}
				$dci++;
        }
        // End delete any comments past 100 off of the tail end -------------  
		
    // INSERT the data into your table now
    $sql = "INSERT INTO messaging (to_id, from_id, time_sent, subject, message) VALUES ('$to', '$from', now(), '$sub', '$msg')"; 
    if (!mysql_query($sql)) { 
	    echo '<img src="images/error.png" alt="Error" width="31" height="30" /> &nbsp;  Could not send message! An insertion query error has occured.';
	    exit();
    } else { 
		echo '<img src="images/success.png" alt="Success" width="31" height="30" /> &nbsp;&nbsp;&nbsp;<strong>Message sent successfully</strong>';
		exit();
    } // close else after the sql DB INSERT check
  } // Close if (empty($sub) || empty($msg)) { 
} // Close if (isset($_POST['message'])) { 
?>