<?php


/*
 * Word of Mouth Registration Page via Facebook
 *
 *
 * License here
 *
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Wordflow Inc
 * @license 	website license here
 *
 */

// start the session, check for login etc..

include_once "mysql_server/checkuserlog.php";

$facebook = (object) config::get_instance()->get('facebook'); 
$get = $_GET;


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Word of Mouth | Registration</title>
		<style type="text/css">
			
			.container {
				width:960px;
				margin:auto;
				position:relative;
				top:100px;
			}
			
			div.error {
				font-family: Helvetica Neue;
				font-size:14px;
				background:#ff6565;
				color:white;
				height:25px;
				line-height:25px;
				width:700px;
				text-align:center;
				margin-top:0px;
				margin-bottom:15px;
				margin-left:auto;
				margin-right:auto;
				border:thin solid #a94343;
				border-radius:4px;
				padding:5px 15px 5px 15px;
			}
			
			iframe#facebook {
				border:none;
				width:700px;
				height:350px;
				display:block;
				margin-left:auto;
				margin-right:auto;
			}
			
		</style>
		<?php require 'templates/header_template.php'; ?>
	
		<div class="container">
		<?php 
			
			if(isset($_GET['form-error']) && $_GET['form-error'] == 1)
			{
				echo "<div class=\"error\">The email you have entered is already in use. Either login or try another email!</div>";
			}
			
		?>
		
		<!-- <div class="error" style="height:100px;">
			<p>Right now, some browsers are not loading the registration form correctly for some users. We are very sorry for this inconvenience. If this form is not working for you, we encourage you to register using another browser while we iron out the problem! <br> Thank you very much - Word Flow Staff</p>
		</div> -->
		<iframe id="facebook" src="https://www.facebook.com/plugins/registration?client_id=<?php echo $facebook->app_id; ?>&redirect_uri=<?php echo $facebook->url_redirect; ?>&fields=name,first_name,last_name,email,password"></iframe>
		
		</div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<?php require 'templates/footer_template.php'; ?>
	</body>
</html>