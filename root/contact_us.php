<?php

 include_once "mysql_server/checkuserlog.php";
 
	$id = $_SESSION['id'];
	$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");


	while($row = mysql_fetch_assoc($sql)){ 
		extract($row);
	
	}	
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Contact Us Page" />
<meta name="Keywords" content="Contact, Us, Help, " />
<meta name="rating" content="General" />
<title>Word of Mouth | Contact Us</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="#" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="#" type="image/x-icon" /> <!-- AND HERE -->
<style>

textarea {
	resize:none;
}

</style>


</head>
<body>
	
	
	<?php include_once 'templates/header_template.php'; ?>

	
<div class="wrapOverall">

         <table class="contentMain" width="690" align="center" cellpadding="8" cellspacing="0">
            <tr>
            <td>
            <div> 
            	<div class="black_text" style="color:black; font-size:18px; margin:20px 10px 10px 10px;" > 
            		At Word Of Mouth we care about what you have to say!<br />
            		Feel free to contact us with any questions, concerns or suggestions<br />
            		that you may have about how to make our site fit your needs!
            	<br /><br />
            	    Email Us at: <a style="color:#0099FF; text-decoration:none;" href="mailto:info@word-flow.com">info@word-flow.com</a>

            	</div>
            </div>
            
		
    	</td>
    	</tr>
	</table>
</div> <!-- END wrapOverall -->

		<?php include_once 'templates/footer_template.php'; ?>


</body>
</html>