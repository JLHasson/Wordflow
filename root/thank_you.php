<?php

 include_once "mysql_server/checkuserlog.php";
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word of Mouth Thank You Page" />
<meta name="Keywords" content="fill, in, information" />
<meta name="rating" content="General" />
<title>Word of Mouth | Thank You!</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->

	<?php include_once 'templates/header_template.php'; ?>
	
    <div class="wrapOverall">

	



        <div class="contentMain">    		
			
			<div class="thankYou">
				<div class="thankYouHeader">
					<h1>Thank you for submiting your feedback!</h1>
				</div>
				<div class="thankYouPara">
					<p>We appreciate you taking the time to tell us what you think!</br>You can click <a href="home.php">here</a> to return home</p>
				</div>
			</div>
			
		</div>

		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>