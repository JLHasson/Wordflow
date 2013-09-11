<?php

if($_SERVER['HTTP_HOST'] !== "word-flow.com") header('location: http://word-flow.com');

 include_once "mysql_server/check_login_form.php";
 

 
?><!DOCTYPEhtml PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Welcome to the Word of Mouth Social Network" />
<meta name="Keywords" content="welcome, to, wordofmouth, word, of, mouth, welcome, page, mouth, referral, recommendations, friends, social" />
<meta name="rating" content="General" />
<title>Welcome to Word of Mouth!</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<style>
.basic {
	color:white; 
	font-family:Arial, Helvetica, sans-serif;
	text-transform:uppercase;
}
.basic a {
	text-decoration:none;
	color:white; 
	font-family:Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	float: right;
}
.basic a:hover {
	text-decoration:none;
	text-decoration:underline;
	color:white; 
	font-family:Arial, Helvetica, sans-serif;
	text-transform:uppercase;
}
</style>
</head>

<body style="background-image:url(site/images/bg_body.png); background-repeat:repeat-x; background-color:#ffffff;">

<div class="bodyWelcome">

    <div class="welcomePageWrapOverall">
    
    	<div class="bgWelcome">
       
			<div class="welcomeLogo">
            	
                <div class="mainLogo">
           
                    <img style="padding:100px 0px 0px 0px; margin:0px 0px 0px 70px" src="images/WordofMouth.jpg" height="170" width="420" />
                	
                    <div class="topLogo">
                    
						<?php include_once "tinyslider2/index.php" ?>
                	
                    </div> <!-- END topLogo -->
                    
                    
                </div> <!-- END mainLogo -->
                
			</div> <!-- END welcomeLogo -->
            
            <div class="bgLogin">
              <div class="loginHereTextWrap">
            
                <div class="loginHereText">Login Here to Get Started:</div>
                
                    
              </div> <!-- END loginHereTextWrap -->
              
              

              <div class="restOfLoginWrap">   
              
                <table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">

                  <tr>
                    <td width="270" valign="top">
                      <tr>
                        <?php print "$errorMsg"; ?></font>
                      </tr>
                  
                      <table width="270" align="center" cellpadding="8" cellspacing="0";>
                        <form action="login.php?attempt=0" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
                          <tr>
                            <td align="right" class="alignRt"><p><strong class="basic">Email:&nbsp</strong></p></td>
                            <td><p>
                              <input name="email" type="text" id="email" style="width:100%;" />
                            </p></td>
                          </tr>
                          <tr>
                            <td align="right" class="alignRt"><strong class="basic">Password:&nbsp</strong></td>
                            <td><input name="pass" type="password" id="pass" maxlength="24" style="width:100%;"/></td>
                          </tr>
                          <tr><td>&nbsp</td></tr>
                          <tr>
                            <td align="right">&nbsp;</td>
                            <td style="color:white; font-family:Arial, Helvetica, sans-serif;text-transform:uppercase;"><input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
                            Remember Me</td>
                          </tr>
                          <tr>
                            <td align="right"><input name="myButton" type="submit" id="myButton" value="Sign In"/></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="basic"><a href="forgot_pass.php">Forgot your password?</a></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          <td align="right" class="basic">or &nbsp;<a href="register.php">Sign Up!</a></td>
                          </tr>
                        </form>
                      </table>
                    </td>
                  </tr>
                </table>                
              </div> <!-- END restOfLoginWrap -->
                
            </div> <!-- END bgLogin -->
            	
        </div> <!-- END bgWelcome -->
 
    
       <?php include_once "templates/footer_template.php";
 		?>
      </div> <!-- END welcomePageWrapOverall -->

</div> <!-- END bodyWelcome -->

</body>


</html>