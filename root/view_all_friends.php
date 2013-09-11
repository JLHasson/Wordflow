<?php

include("mysql_server/checkuserlog.php");

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
	$sign_up_date = $row["sign_up_date"];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
	$last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));	
	$bio_body = $row["bio_body"];	
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	
}



$getId = $_GET['id'];
$checkTable = mysql_query("SELECT id FROM `myMembers` WHERE id = '$getId'");
$num_rows = mysql_num_rows($checkTable);

if ($num_rows > 0) {
	}
$outputList = '';
$getId = $_GET['id'];
$review_query = mysql_query("SELECT * FROM `myMembers` WHERE id = '$getId'");

while($friend_row = mysql_fetch_assoc($review_query)){
	$friend_array = $friend_row["friend_array"];
	$firstname = $friend_row["firstname"];
	$lastname = $friend_row["lastname"];
}
	
	
	
	$friendList = '';
if($friend_array != "") {

		$friendArray = explode(",", $friend_array);
		$friendCount = count($friendArray);
			
		$friendList .= '
			<div style="margin-left:10px;">
				<div class="user_friends_header" style="float:left;">'. $firstname.' '. $lastname .'\'s Friends</div>
				<div class="#" style="float:right;">
					Displaying '. $friendCount .' Friends 
				</div>
			</div>
			
			<br />
			<hr style="margin:0px 5px 0px 5px;" />';
		$i = 0;
		$friendList .= '<div><table id="friendTable" align="left" cellspacing="5"><tr>';
		foreach($friendArray as $key => $value){
			$i++;
			$check_pic = 'members/'. $value .'/thumb_image01.jpg';
				if(file_exists($check_pic)){
					$friend_picture = '<a href = "profile.php?id='. $value .'"><img src="'. $check_pic .'" width="70" /></a>';
				} else {
					$friend_picture = '<a href = "profile.php?id='. $value .'"><img src="../../members/0/image01.jpg" width="70" /></a>';
				}
				
				$name_query = mysql_query("SELECT firstname, lastname FROM myMembers where id=$value LIMIT 1") or die("Sorry, Mysql Error");
				
				while($row= mysql_fetch_assoc($name_query)){ $friendFirstname = $row['firstname']; $friendLastname = $row['lastname']; }
				if ($i % 5){
				
					$friendList .= '<td><div class="friends_box_name" style="width:110px; height:100px;" title="' . $friendFirstname . ' '. $friendLastname .'">
					' . $friend_picture . '<br /><br /><a href = "profile.php?id='. $value .'">' . $friendFirstname . ' '. $friendLastname .'</a>
					</div></td>'; 
				} else {
				
					$friendList .= '<td><div class="friends_box_name" style="width:110px; height:100px;" title="' . $friendFirstname . ' '. $friendLastname .'">
					' . $friend_picture . '<br /><br /><a href = "profile.php?id='. $value .'">' . $friendFirstname . ' '. $friendLastname .'</a>
					</div></td></tr>'; 
				}
									
		}
		$friendList .= '</table></div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Template Page" />
<meta name="Keywords" content="fill, in, information" />
<meta name="rating" content="General" />
<title>Word of Mouth | All Friends</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
</head>
<body>
	<?php include_once 'templates/header_template.php'; ?>

    <div class="wrapOverall">

        <div class="contentLeft" width="690px" height="1000px" align="left" cellpadding="8" cellspacing="0">    		
        <table width="690px">
        <?php echo $friendList; ?>
        </table>
        </div>
        <div class="contentRight" width="270" height="1000px" align="right" cellpadding="8" cellspacing="0">
		
		</div>

		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>