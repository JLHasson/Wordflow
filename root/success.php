<?php

require 'templates/header_template.php';
			
			$msgToUser = "<h2>One Last Step - Activate through Email</h2><h4> There is one last step to verify your email identity:</h4><br />
       In a moment you will be sent an Activation link to your email address.<br /><br />
       <br />
       <strong><font color=\"#990000\">VERY IMPORTANT:</font></strong> 
       If you check your email with your host providers default email application, there may be issues finding the email. Please be sure to check your spam folder.<br /><br />
       ";
       	
       	echo "<br><br><br><br><br>";
       
		echo $msgToUser;
		
		require 'templates/footer_template.php';
		
		?>