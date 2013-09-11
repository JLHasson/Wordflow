<?php

include_once "mysql_server/checkuserlog.php";
 
error_reporting(E_ALL);

ini_set("display_errors",0);

// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------


if (isset($_SESSION['id'])) {
	 $id = $logOptions_id;
} else if (isset($_GET['id'])) {
	 $id = preg_replace('#[^0-9]#i', '', $_GET['id']); // filter everything but numbers
} else {
   header("location: index.php");
   exit();
}
$cacheBuster = rand(999999999,9999999999999);
//This code is used to display the logged in users information (ex. firstname lastname etc.)
$id = mysql_real_escape_string($id); 
$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");

// ------- START WHILE LOOP FOR GETTING THE MEMBER DATA ---------
while($row = mysql_fetch_array($sql)){ 
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$country = $row["country"];	
	$state = $row["state"];
	$sign_up_date = $row["sign_up_date"];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
	$last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));	
	$bio_body = $row["bio_body"];	
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	$friend_array = $row["friend_array"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "../members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"80px\" />"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
	}
}

// why not store all the referrals and reviews inside an array?

// and then foreach through each one to display the markup?





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word of Mouth Browse Page" />
<meta name="Keywords" content="wordofmouth, word, of mouth, browse, page, social, network, reviews, referrals" />
<meta name="rating" content="General" />
<title>Word of Mouth | Browse</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
</head>
<body>

			<?php include_once 'templates/header_template.php'; ?>

      <div class="wrapOverall">





        <div class="contentMain" width="987px" height="1000px" align="left" cellpadding="8" cellspacing="0" style="background-color:#FBFBFB;">    		
        
		<h1 id="browseWords">Welcome <?php echo $firstname; ?>, what would you like to find? <a href="help.php" style="font-size:12px; text-decoration:none;color:#0099FF; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;" title="Click Here!">Need Help?</a></h1>

        <table width="985px" height="1000px" align="left" cellpadding="8" cellspacing="0">
        	<tr valign="top" height="50px">
        		<td width="50%">
				
					<h2>Review Categories:</h2>

					<a class="browseButtonsLink" href="home.php?filterBy=1_1"><div class="browseButtons">Appliances</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_2"><div class="browseButtons">Apps (Android/Apple)</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_3"><div class="browseButtons">Automotive</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_4"><div class="browseButtons">Baby</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_5"><div class="browseButtons">Beauty and Make-Up</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_6"><div class="browseButtons">Books & Art</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_7"><div class="browseButtons">Clothing & Accessories</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_8"><div class="browseButtons">Electronics</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_9"><div class="browseButtons">Food</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_10"><div class="browseButtons">Home and Furniture</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_11"><div class="browseButtons">Music </div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_18"><div class="browseButtons">Movies</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_12"><div class="browseButtons">Lawn & Garden</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_13"><div class="browseButtons">Pet Supplies</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_14"><div class="browseButtons">Sports and Outdoor</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_15"><div class="browseButtons">Tools/Home Improvement</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_16"><div class="browseButtons">Toys & Games</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=1_17"><div class="browseButtons">Miscellaneous</div></a>

				</td>
				<td width="50%">
				
					<h2>Referral Categories:</h2>
					
					<a class="browseButtonsLink" href="home.php?filterBy=2_1"><div class="browseButtons">Automotive</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_2"><div class="browseButtons">Business & Prof. Services</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_3"><div class="browseButtons">Clothing & Accessories</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_4"><div class="browseButtons">Computers & Electronics</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_5"><div class="browseButtons">Construction/Contractors</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_6"><div class="browseButtons">Education</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_7"><div class="browseButtons">Entertainment</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_8"><div class="browseButtons">Food & Dining</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_9"><div class="browseButtons">Health & Medicine</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_10"><div class="browseButtons">Home & Garden</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_11"><div class="browseButtons">Legal & Financial</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_12"><div class="browseButtons">Media & Communications</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_19"><div class="browseButtons">Online Shopping</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_13"><div class="browseButtons">Personal Care & Services</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_14"><div class="browseButtons">Real Estate</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_15"><div class="browseButtons">Shopping</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_16"><div class="browseButtons">Sports & Recreation</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_17"><div class="browseButtons">Travel & Transportation</div></a>
					<a class="browseButtonsLink" href="home.php?filterBy=2_18"><div class="browseButtons">Miscellaneous</div></a>
				</td>
			</tr>
        </table>
					
		</div> <!-- END contentMain -->
        
		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>