<?php

include_once("mysql_server/checkuserlog.php");
if (!$_SESSION['idx']) { 
    $msgToUser = '<br /><br /><font color="#FF0000">Only site members can do that</font><p><a href="register.php">Join Here</a></p>';
    include_once 'msgToUser.php'; 
    exit(); 
} else if ($logOptions_id != $_SESSION['id']) {
	$msgToUser = '<br /><br /><font color="#FF0000">Only site members can do that</font><p><a href="register.php">Join Here</a></p>';
    include_once 'msgToUser.php'; 
    exit(); 
}
////////////////////////////////////////////////      End Member log in double check       ///////////////////////////////////////
$id = $logOptions_id; // Set the profile owner ID
// Now let's initialize vars to be printed to page in the HTML section so our script does not return errors 
// they must be initialized in some server environments, not shown in video
$error_msg = ""; 
$errorMsg = "";
$success_msg = "";
$firstname = "";
$middlename = "";
$lastname = "";
$bio_body = "";
$bio_body = "";
$facebook_token = "";
$user_pic = "";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ------- IF WE ARE PARSING ANY DATA ------------------------------------------------------------------------------------------------------------
if (isset($_POST['parse_var'])){
	

  //------------------------------------------------------------------------------------------------------------------------
  // ------- PARSING PICTURE UPLOAD ---------
  if ($_POST['parse_var'] == "pic"){
  	
  // Access the $_FILES global variable for this specific file being uploaded
  // and create local PHP variables from the $_FILES array of information
  $fileName = $_FILES["fileField"]["name"]; // The file name
  $fileTmpLoc = $_FILES["fileField"]["tmp_name"]; // File in the PHP tmp folder
  $fileType = $_FILES["fileField"]["type"]; // The type of file it is
  $fileSize = $_FILES["fileField"]["size"]; // File size in bytes
  $fileErrorMsg = $_FILES["fileField"]["error"]; // 0 for false... and 1 for true
  $kaboom = explode(".", $fileName); // Split file name into an array using the dot
  $fileExt = end($kaboom); // Now target the last array element to get the file extension
  // START PHP Image Upload Error Handling --------------------------------------------------
  if($fileTmpLoc == " ") {
   
  } else if($fileSize > 52428800) { // if file size is larger than 5 Megabytes
       $error_msg = '<font color="#FF0000">ERROR: Your image was too large, please try again.</font>';
                          unlink($_FILES['fileField']['tmp_name']); 
                          
  } else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
       // This condition is only if you wish to allow uploading of specific file types    
       $error_msg = '<font color="#FF0000">ERROR: Your image was not one of the accepted formats, please try again.</font>';
                          unlink($_FILES['fileField']['tmp_name']); 
                          
  } else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
      $error_msg = '<font color="#FF0000">ERROR: An error occured while processing the file. Try again.</font>';
                          unlink($_FILES['fileField']['tmp_name']); 
  }
  // END PHP Image Upload Error Handling ---------------------------------

  //CHANGE THE NAME OF THE PHOTO TO MATCH THE REVIEW ID NUMBER

  // Place it into your members folder mow using the move_uploaded_file() function
  $newname = "image01.jpg";
  $id = $_SESSION['id'];
  $place_file = move_uploaded_file($fileTmpLoc, "members/$id/".$newname);
  // Check to make sure the move result is true before continuing
  if ($place_file != true) {
      echo "ERROR: File not uploaded. Try again.";
      exit();
  }

  // ---------- Include Universal Image Resizing Function --------
  include_once("include/php_img_lib_1.0.php");
  $target_file = "members/$id/image01.jpg";
  $resized_file = "members/$id/resized_image01.jpg";
  $wmax = 300;
  $hmax = 300;
  ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

  // ------ Start Universal Image Thumbnail(Crop) Function ------
  $target_file = "members/$id/resized_image01.jpg";
  $thumbnail = "members/$id/thumb_image01.jpg";
  $wthumb = 200;
  $hthumb = 200;
  ak_img_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);
  // ------- End Universal Image Thumbnail(Crop) Function -------
  $sucess_msg = "Your Photo Post was sucessful!";

  }
  // ------- END PARSING PICTURE UPLOAD ---------
  //------------------------------------------------------------------------------------------------------------------------
  // ------- PARSING PERSONAL INFO ---------
  if ($_POST['parse_var'] == "location"){
  	
  	$firstname = preg_replace('#[^A-Za-z]#i', '', $_POST['firstname']); // filter everything but desired characters
  	$lastname = preg_replace('#[^A-Za-z]#i', '', $_POST['lastname']); // filter everything but desired characters	
  	$sqlUpdate = mysql_query("UPDATE myMembers SET firstname='$firstname', lastname='$lastname' WHERE id='$id' LIMIT 1");
      if ($sqlUpdate){
          $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Information has been updated successfully.';
      } else {
  		$error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
      }
  }
  // ------- END PARSING LOCATION INFO ---------
  //------------------------------------------------------------------------------------------------------------------------
  // ------- PARSING BIO ---------
  if ($_POST['parse_var'] == "bio"){
  	
  	$bio_body = $_POST['bio_body'];
  	$bio_body = str_replace("'", "&#39;", $bio_body);
  	$bio_body = str_replace("`", "&#39;", $bio_body);
    $bio_body = mysql_real_escape_string($bio_body);
    $bio_body = nl2br(htmlspecialchars($bio_body));
  	 // Update the database data now here for all fields posted in the form
  	 $sqlUpdate = mysql_query("UPDATE myMembers SET bio_body='$bio_body' WHERE id='$id' LIMIT 1");
       if ($sqlUpdate){
              $success_msg = '<img src="images/success.png" width="20" height="20" alt="Success" />Your description information has been updated successfully.';
       } else {
  		    $error_msg = '<img src="images/error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
       }
  }
  // ------- END PARSING BIO ---------
  //------------------------------------------------------------------------------------------------------------------------
  // ------- PARSING OPTOUT OPTION ---------
  if ($_POST['parse_var'] == "optoutclick"){
  	
  	$optout = $_POST['optout']; // filter everything but desired characters
  	$sqlUpdate = mysql_query("UPDATE myMembers SET `optout`='$optout' WHERE `id`='$id' LIMIT 1");
      if ($sqlUpdate){
          $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Information has been updated successfully.';
      } else {
  		$error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
      }
  }
  
  

  
  
  // ------- END PARSING OPTOUT OPTION---------
  // ------- PARSING PERSONAL INFO ---------
  if ($_POST['parse_var'] == "passwordSubmit"){
    
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    $pass1 = stripslashes($pass1); 
    $pass2 = stripslashes($pass2); 

    $pass1 = strip_tags($pass1);
    $pass2 = strip_tags($pass2);

    $pass1 = mysql_real_escape_string($pass1);
     
    if ($pass1 != $pass2) {
      $errorMsg = 'ERROR: Your Password fields below do not match<br />';
    } else {
      // Add MD5 Hash to the password variable
      $db_password = md5($pass1); 

      $sqlUpdate = mysql_query("UPDATE myMembers SET `password`='$db_password' WHERE `id`='$id' LIMIT 1");
      if ($sqlUpdate){
          $success_msg = 'Password has been updated successfully.';
      } else {
          $error_msg = 'ERROR: Problems arose during the information exchange, please try again later.</font>';
      }
    }
  }
  // ------- END PARSING LOCATION INFO ---------
  if ($_POST['parse_var'] == "deleteProfile"){
    if($_POST[delete_checkbox] == "true") {
      $ok = @mysql_query("DELETE FROM myMembers WHERE `id`='$id'");

      if ($ok) {
        
        include_once ('logout.php');
        header('location: http://www.word-flow.com/welcome.php');    

      } else {
        
        echo('<p>Error deleting profile from database!<br />'.
             'Error: ' . mysql_error() . '</p>');

      }
    }
  }
  //------------------------------------------------------------------------------------------------------------------------
  //////////////////////////////////////////////////////////////////////////////////
} // <<--- This closes "if ($_POST['parse_var']){"
// ------- END IF WE ARE PARSING ANY DATA ------------------------------------------------------------------------------------------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// All parsing has ended by this point in the script, so query the most current data for member
// This will show refreshed data to the user so they do not see old data after making changes
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Final default sql query that will refresh the member data on page, and show most current
$sql_default = mysql_query("SELECT * FROM myMembers WHERE id='$id'");

while($row = mysql_fetch_array($sql_default)){ 
	
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$bio_body = $row["bio_body"];
	
	// facebook check
	
	$facebook_token = $row['access_token'];
	
	
	
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
  	$bio_body = str_replace("<br />", "", $bio_body);
  	$bio_body = stripslashes($bio_body);
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"50px\" />"; // forces picture to be 100px wide and no more
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"50px\" />"; // forces default picture to be 100px wide and no more
	}
	

} // close while loop



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta name="Description" content="Profile for <?php echo "$firstname, $lastname"; ?>" />
<meta name="Keywords" content="<?php echo "$firstname, $lastname, $city, $state, $country"; ?>" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Word of Mouth | Edit Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="#" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="#" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<style type="text/css">
<!--
.brightRed {	color: #F00;}
.textSize_9px {	font-size: 9px;}
h1 { display:inline;	}
h2 { display:inline; }
h3 { display:inline;	}
.boxHeader {
	border:#999 1px solid; background-color: #FFF; background-image:url(style/accountStrip1.jpg); background-repeat:repeat-x; padding:5px; margin-left:19px; margin-right:20px; margin-top:6px; color:#060; text-decoration:none;
}

.boxHeader a:link {
	color: #0099FF;
	text-decoration:none;
}
.boxHeader a:hover {
	color: #000000;
	text-decoration:none;
}
.editBox {
	display:none;
}
-->
</style>
<script language="javascript" type="text/javascript"> 
function toggleSlideBox(x) {
		if ($('#'+x).is(":hidden")) {
			$(".editBox").slideUp(200);
			$('#'+x).slideDown(300);
		} else {
			$('#'+x).slideUp(300);
		}
}
</script>
</head>
<body>
<?php include_once "templates/header_template.php"; ?>
<div class="wrapOverall">
<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="987" valign="top"><br />
      <table width="94%" border="0" align="center">
        <tr>
          <td><h3><?php echo $success_msg; ?><font color="#FF0000"><?php echo $errorMsg; ?></font></h3>            <h2>&nbsp;</h2></td>
        </tr>
      </table>
      <br />
      
      <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('picBox');">
      <h2>Profile Picture</h2>
      </a> 
      </div>
      <div class="editBox" id="picBox">
        <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
          <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <tr>
              <td width="61"><?php echo $user_pic; ?></td>
              <td width="521">
              Your Photo will be cropped square to fit the thumbnail
              <input name="fileField" type="file" class="formFields" id="fileField" size="42" />
              </td>
              <td width="56"><input name="updateBtn1" type="submit" id="updateBtn1" value="Update" />
                <input name="parse_var" type="hidden" value="pic" />
              </td>
            </tr>
          </form>
        </table>
      </div>
      <!-- -->
      <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('locationBox');">
      
      <h2>Personal Information</h2>
      </a>
      </div>
      <div class="editBox" id="locationBox">
      <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
          <tr>
            <td width="602"><table width="100%" border="0" align="center">
              <tr>
                <td width="34%"><strong>First Name</strong></td>
                <td width="33%"><strong>Last Name</strong></td>
                <td width="33%">&nbsp;</td>
              </tr>
            </table>
              <table width="100%" border="0" align="center">
              <tr>
                <td width="34%"><input name="firstname" type="text" class="formFields" id="firstname" value="<?php echo $firstname; ?>" style="width:99%" maxlength="20" /></td>
                <td width="33%"><input name="lastname" type="text" class="formFields" id="lastname" value="<?php echo $lastname; ?>" style="width:99%" maxlength="20" /></td>
                <td width="33%">&nbsp;</td>
              </tr>
            </table>
            </td>
            <td width="56" valign="top"><input name="updateBtn2" type="submit" id="updateBtn2" value="Update" />
              <input name="parse_var" type="hidden" value="location" />
            <input name="thisWipit" type="hidden" value="<?php echo $thisRandNum; ?>" /></td>
          </tr>
        </form>
      </table>
      </div>
      <!-- -->
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('bioBox');">
     <h2>Description</h2>
      </a>
      </div>
    <div class="editBox" id="bioBox">
    <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
      <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <tr>
          <td width="602" valign="top"><textarea name="bio_body" cols="" rows="3" class="formFields" style="width:80%; resize:none;"><?php echo $bio_body; ?></textarea></td>
          <td width="56" valign="top"><input name="updateBtn4" type="submit" id="updateBtn4" value="Update" />
            <input name="parse_var" type="hidden" value="bio" />
          </tr>
      </form>
    </table>
    </div>
    
    
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('emailalertBox');">
	 <h2>Opt Out Of Link Insertion</h2>
      </a>
      </div>
    <div class="editBox" id="emailalertBox">
    <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
       <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <tr>
			<td>
			<p>If you do not post a link, our team of experts is able to add links to your posts
			making it easy for your friends to find the products that you review. You may choose to turn
			this option off if you do not want any links posted. We recommend leaving this on unless you
			plan on filling in your website every time.<br />
			<select name="optout">
				<option value="0">On</option>
				<option value="1">Off</option>
			</select>
			<input name="updateBtn5" type="submit" id="updateBtn5" value="Update" />
			<input name="parse_var" type="hidden" value="optoutclick" />
			</td>
       	</tr>
       </form>
    </table>
    </div>   
    <!-- -->
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('passwordBox');">
       <h2>Account Settings</h2>
      </a>
    </div>
    <div class="editBox" id="passwordBox">
      <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
          <tr>
            <td width="602">
              <table width="100%" border="0" align="center">
                <tr>
                  <td width="34%"><strong>Password</strong></td>
                  <td width="33%"><strong>Confirm Password</strong></td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
              <table width="100%" border="0" align="center">
                <tr>
                  <td width="34%"><input name="pass1" type="text" class="formFields" id="pass1" value="" style="width:99%" maxlength="20" /></td>
                  <td width="33%"><input name="pass2" type="text" class="formFields" id="pass2" value="" style="width:99%" maxlength="20" /></td>
                  <td width="33%">&nbsp;</td>
                </tr>
              </table>
            </td>
            <td width="56" valign="top">
              <input name="updateBtn6" type="submit" id="updateBtn6" value="Update" />
              <input name="parse_var" type="hidden" value="passwordSubmit" />
          </tr>
        </form>
      </table>
    </div>
    <div class="boxHeader">
      <a href="#" onclick="return false" onmousedown="javascript:toggleSlideBox('deleteBox');">
       <h2>Delete Profile</h2>
      </a>
    </div>
    <div class="editBox" id="deleteBox">
      <table width="949" align="center" cellpadding="10" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
          <tr>
            <td width="602">
              <p>Delete your profile? All reviews you have written
               will be deleted and your profile will be eliminated. 
               Are you sure you want to do this?</p>
              <input type="checkbox" name="delete_checkbox" value="true" />Yes, Delete Me
              <input name="updateBtn7" type="submit" id="updateBtn7" value="Update" />
              <input name="parse_var" type="hidden" value="deleteProfile" />
            </td>
          </tr>
        </form>
      </table>
    </div>
    <br />
    <br /></td>
  </tr>
</table>

<?php include_once "templates/footer_template.php"; ?>
</div> <!-- END wrapOverall -->
</body>
</html>