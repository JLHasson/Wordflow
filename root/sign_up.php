<?php
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once "../../mysql_server/checkuserlog.php";

$from = ""; // Initialize the email from variable
// This code runs only if the firstname is posted
if (isset ($_POST['firstname'])){
	 
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email1 = $_POST['email1'];
  $email2 = $_POST['email2'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  $agreeService = $_POST['termsOfService'];
  $newsletterSub = $_POST['newsletter'];

  $humancheck = $_POST['humancheck'];


  $firstname = stripslashes($firstname);
  $lastname = stripslashes($lastname);
  $email1 = stripslashes($email1); 
  $pass1 = stripslashes($pass1); 
  $email2 = stripslashes($email2);
  $pass2 = stripslashes($pass2); 

  $firstname = strip_tags($firstname);
  $lastname = strip_tags($lastname);
  $email1 = strip_tags($email1);
  $pass1 = strip_tags($pass1);
  $email2 = strip_tags($email2);
  $pass2 = strip_tags($pass2);
//done

       $emailCHecker = mysql_real_escape_string($email1);
  	   $emailCHecker = str_replace("`", "", $emailCHecker);
  	   // Database duplicate firstname check setup for use below in the error handling if else conditionals
  	   $sql_fname_check = mysql_query("SELECT firstname FROM myMembers WHERE firstname='$firstname'"); 
       $fname_check = mysql_num_rows($sql_fname_check);
       // Database duplicate e-mail check setup for use below in the error handling if else conditionals
       $sql_email_check = mysql_query("SELECT email FROM myMembers WHERE email='$emailCHecker'");
       $email_check = mysql_num_rows($sql_email_check);

  // Error handling for missing data
  if ((!$firstname) || (!$lastname) || (!$email1) || (!$email2) || (!$pass1) || (!$pass2) || (!$agreeService)) { 

    $errorMsg = 'ERROR: You did not submit the following required information:<br /><br />';

    if(!$firstname){ 
    $errorMsg .= ' * First Name<br />';
    } 
    if(!$lastname){ 
    $errorMsg .= ' * Last Name<br />';
    }
    if(!$email1){ 
    $errorMsg .= ' * Email Address<br />';      
    }
    if(!$email2){ 
    $errorMsg .= ' * Confirm Email Address<br />';        
    } 	
    if(!$pass1){ 
    $errorMsg .= ' * Login Password<br />';      
    }
    if(!$pass2){ 
    $errorMsg .= ' * Confirm Login Password<br />';        
    } 	
    if(!$agreeService){
    $errorMsg .= ' * Must agree to Terms of Service<br />';
    }

    if ($email1 != $email2) {
    $errorMsg .= ' * Your Email fields below do not match<br />';
    } else if ($pass1 != $pass2) {
    $errorMsg .= ' * Your Password fields below do not match<br />';
    } else if ($humancheck != "") {
    $errorMsg .= ' * Please remove the text below to confirm you are not an alien!<br />';		 
    } else if ($email_check > 0){ 
    $errorMsg .= " * Your Email address is already in use inside of our system. Please use another.<br />"; 
    } // Error handling is ended, process the data and add member to database
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  } else {
         $email1 = mysql_real_escape_string($email1);
         $pass1 = mysql_real_escape_string($pass1);
    	 
         // Add MD5 Hash to the password variable
         $db_password = md5($pass1); 
    	
        if ($newsletterSub == true) {
    	    $name = ''.$firstname .' '. $lastname.'';
    	    $sql_insert = mysql_query("INSERT INTO newsletter (name, email, dateTime) VALUES('$name','$email1',now() )") or die(mysql_error());
    								
    	   }
    	
        
         // Add user info into the database table for the main site table
         $sql = mysql_query("INSERT INTO myMembers (firstname, lastname, email, password, sign_up_date) 
         VALUES('$firstname','$lastname','$email1','$db_password', now())")  
         or die (mysql_error());
     
         $id = mysql_insert_id();
    	 
    	 // Create directory(folder) to hold each user's files(pics, MP3s, etc.)		
        mkdir("../../members/$id", 0777);	

        //!!!!!!!!!!!!!!!!!!!!!!!!!    Email User the activation link    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $to = "$email1";
    										 
        $from = "admin@tempwordofmouth.com" ; // $adminEmail is established in [ scripts/connect_to_mysql.php ]
        $subject = 'Complete Your Word Of Mouth Registration';
        //Begin HTML Email Message
        $message = "Hi $firstname,

       Complete this step to activate your login identity at Word of Mouth

       Click the line below to activate when ready

       http://www.tempwordofmouth.com/new_user/new_user/activation.php?id=$id&sequence=$db_password
       If the URL above is not an active link, please copy and paste it into your browser address bar

       Login after successful activation using your:  
       E-mail Address: $email1 
       Password: $pass1

       See you on the site!";
       //end of message
    	 $headers  = "From: $from\r\n";
        $headers .= "Content-type: text\r\n";

        mail($to, $subject, $message, $headers);
    	
       $msgToUser = "<h2>One Last Step - Activate through Email</h2><h4>$firstname, there is one last step to verify your email identity:</h4><br />
       In a moment you will be sent an Activation link to your email address.<br /><br />
       <br />
       <strong><font color=\"#990000\">VERY IMPORTANT:</font></strong> 
       If you check your email with your host providers default email application, there may be issues finding the email. Please be sure to check your spam folder.<br /><br />
       ";
       
       include_once '../../new_user/new_user/msgToUser.php'; 
       exit();

  } // Close else after duplication checks

} else { // if the form is not posted with variables, place default empty variables so no warnings or errors show
  	  
  	  $errorMsg = "[ * ] are required";
      $firstname = "";
  	  $lastname = "";
  	  $email1 = "";
  	  $email2 = "";
  	  $pass1 = "";
  	  $pass2 = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Register Domain" />
<meta name="Keywords" content="register, domain" />
<meta name="rating" content="General" />
<title>Register with Word of Mouth</title>
<link href="../../style.css" rel="stylesheet" type="text/css" />
<link href="../../include/lightbox.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="../../favicon" type="image/x-icon"> 
<link rel="shortcut icon" href="../../favicon" type="image/x-icon"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../../include/lightbox.js"></script>

<style type="text/css">
.wrapOverall {z-index: 1;}
.style26 {color: #FF0000}
.style28 {font-size: 14px}
.brightRed {
	color: #F00;
}
.textSize_9px {
	font-size: 9px;
}
.container {
	background:#0099FF; 
	color:#0099FF; 
	margin:0 15px;
}

.rtop, .rbottom{
	display:block;
	background:#fff;
}
.rtop *, .rbottom *{
	display: block;
	height: 1px;
	overflow: hidden;
	background:#0099FF;
}
.r1{
 	margin: 0 5px}
.r2{
	margin: 0 3px
}
.r3{
	margin: 0 2px
}
.r4{
	margin: 0 1px;
	height: 2px
}
</style>
</head>
<body>

	<?php 
		if (isset($_SESSION['id'])){
			echo '
			<div class="signedIn">
				<div id="signedIn"> 
					<p class="black_text">Uh-oh! You are already signed in!<br />Please <a href="../../pages/log_page/logout.php">sign out</a> to create a new account!</p>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function () {
					$(".wrapOverall").hide();
				});
			</script>
			';
		} 
	?>

<div class="wrapOverall" align="center" >

<div>
		
		<div class="facebook-register">
			
			
			
		</div>
    
    	<div class="bgRegister">
    	<div width="600px;">
    	<b class="rtop"><b class="r1"></b> <b class="r2"></b> <b class="r3"></b> <b class="r4"></b></b> 
    	</div>
	
<table class="mainBodyTable" margin="0px" bgcolor="#0099FF" align="center" cellpadding="0" cellspacing="0">
<tr>
<td bgcolor="#0099FF" align="center"> <img SRC="../../images/WordofMouthLogo.png" width="200" height="80" > </td>
</tr>
<tr>
        <td width="753px" valign="top" align="center">
    
            <h2 style="margin-left:10px; color:#FFF;">Create A New Account to get started!</h2>
            <p style="margin-left:80px;">&nbsp;</p>
    </td>
    
</tr>
          <table bgcolor="#09F" width="600" align="center" cellpadding="8" cellspacing="0" style="color:#FFF;" >
                
            <form action="" method="post" enctype="multipart/form-data">
              <tr>
                <td colspan="2" bgcolor="#09F"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F" >First Name:<span class="brightRed"> *</span></td>
                <td bgcolor="#09F"><input name="firstname" type="text" class="formFields" id="firstname" value="<?php print "$firstname"; ?>" size="32" maxlength="20" /></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Last Name:<span class="brightRed"> *</span></td>
                <td bgcolor="#09F"><input name="lastname" type="text" class="formFields" id="lastname" value="<?php print "$lastname"; ?>" size="32" maxlength="20" /></td>
              </tr>                    
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Email Address: <span class="brightRed">*</span></td>
                <td bgcolor="#09F"><input name="email1" type="text" class="formFields" id="email1" value="<?php print "$email1"; ?>" size="32" maxlength="48" /></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Confirm Email:<span class="brightRed"> *</span></td>
                <td bgcolor="#09F"><input name="email2" type="text" class="formFields" id="email2" value="<?php print "$email2"; ?>" size="32" maxlength="48" /></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Create Password:<span class="brightRed"> *</span></td>
                <td bgcolor="#09F"><input name="pass1" type="password" class="formFields" id="pass1" size="32" maxlength="16" />
                  <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Confirm Password:<span class="brightRed"> *</span></td>
                <td bgcolor="#09F"><input name="pass2" type="password" class="formFields" id="pass2" size="32" maxlength="16" />
                <span class="textSize_9px"><span class="greyColor">Alphanumeric Characters Only</span></span></td>
              </tr>
              <tr>
                <td align="right" class="alignRt" bgcolor="#09F">Human Check: <span class="brightRed">*</span></td>
                <td bgcolor="#09F"><input name="humancheck" type="text" class="formFields" id="humancheck" value="Please remove all of this text" size="32" maxlength="32" />
                </td>
              </tr>
			  <tr>
				<td align="right" class="alignRt"><span>Agree to the Terms of Service: </span><span class="brightRed">*</span></td>
				<td><input type="checkbox" name="termsOfService" value="I agree" /><span class="textSize_9px"><span class="greyColor"><a href="../../pages/privacy_policy_page/privacy_policy_page.php" id="readTerms" style="text-decoration: none; cursor: pointer;">Read our Privacy Policy</a></span></span></td>
			  </tr>
			  <tr>
				<td align="right" class="alignRt"><span>Sign up to our newsletter!</span></td>
				<td><input type="checkbox" name="newsletter" checked="checked" /></td>
			  </tr>
              <tr>
                <td bgcolor="#09F">&nbsp;</td>
                <td bgcolor="#09F"><p>
                  <input type="submit" name="Submit" value="Sign Up!" />
                </p></td>
              </tr>
            </form>
          </table> 

      </tr>
    </table>
   <b class="rbottom"><b class="r4"></b> <b class="r3"></b> <b class="r2"></b> <b class="r1"></b></b>	
    </div>

		<?php include_once "../../templates/footer_template.php";?>
</div>  <!-- END wrapOverall -->
</body>
</html>

