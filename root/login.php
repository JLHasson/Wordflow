<?php

 include_once "mysql_server/checkuserlog.php";
 include_once "mysql_server/check_login_form.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.4.2.js"></script>

<title>Log In</title>
<style type="text/css">
body {
	margin-top: 0px;
}
</style></head>
<body>
<?php include_once('templates/header_template.php'); ?>
<div class="wrapOverall">


	<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
        <td width="600" valign="top">
  <tr>
      <h2 style="margin-left:200px; margin-top:40px; color:#06A1f1;">Please Enter Your Username and Password:</h2>
      <td width="29%"><p style="margin-left:200px"><font color="#FF0000"><br />
	<?php print "$errorMsg"; ?></font></style></td>
  </tr>
  
<table width="600" align="center" cellpadding="8" cellspacing="0" style="border:#999 1px solid; background-color:#FBFBFB;">
  <form action="" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
    <tr>
      <td align="right" class="alignRt"><p><strong>Email:</strong></p></td>
      <td><p>
        <input name="email" type="text" id="email" style="width:60%;" />
      </p></td>
    </tr>
    <tr>
      <td align="right" class="alignRt"><strong>Password:</strong></td>
      <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
    </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td><input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
        Remember Me</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="myButton" type="submit" id="myButton" value="Sign In"/></td>
      <td align="left"><a href="register.php">Sign Up</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Forgot your password? <a href="forgot_pass.php">Click Here</a></td>
    </tr>
  </form>
</table>
</table>
</table>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php include_once('templates/footer_template.php'); ?>
</div> <!-- END wrapOverall -->
</body>


</html>