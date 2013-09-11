<?php

 include_once "mysql_server/checkuserlog.php";
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth About Us Page" />
<meta name="Keywords" content="word, of, mouth, about, us, page" />
<meta name="rating" content="General" />
<title>Word of Mouth | About Us</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<style type="text/css">
.wrapOverall_about {
	width:600px;
	padding-top:65px;
	margin-left:auto;
	margin-right:auto;
}
.headerText{
	text-decoration:none;
	font-weight:normal;
	font-size:14px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	text-transform:bold; uppercase;
}
.bodyText {
	text-decoration:none;
	font-weight:normal;
	font-size:12px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
.pic_container {
	margin-left:auto;
	margin-right:auto;
	width:500px;
	
}
.row_1 {
	width:790px;
	height:110px;
}
.individual {

}
</style>
</head>
<body>

	<?php include_once 'templates/header_template.php'; ?>

<div class="wrapOverall_about">


        <div height="25px" align="center" valign="top">
    			<div style="padding-top: 1em;">
    				
    				<h1>About Us</h1>
				
				</div>
		</div>
		
    	<div align="left" valign="top">
			
			<div style="padding-left: 1em; padding-top: 1em;">
				Take products and businesses you love, and share them with your friends! This is the vision of Word of Mouth, and we're happy to share it with you! We've created a simple system where you can share what you love using, see what your friends love using, and join in on the discussion of what's the best product or service out there. It's a simple idea that we hope will make your search for the best products and businesses much quicker and easier.<br /><br />
			</div>
		<hr />
		
			
		</div>

			
	<div class="teamBio" style="margin-left: auto; margin-right: auto;">
		
	<table class="pic_container">		
		<tr class="row_1">
			<!-- Mike's Row -->
					<td class="individual">
						
							<img src="images/bio/mike_bio.jpg" width="150px"/>
							<br /><span class="blue_text">Mike Avery</span>
					
					</td>
					

			<!-- Lance's Row -->
					<td class="individual">
						
							<img src="images/bio/lance_bio.jpg" width="150px"/>
							<br /><span class="blue_text">Lance Hasson</span>
							
					</td>
				</div>
		</tr>
	</table>
	<hr />
		<?php include_once 'templates/footer_template.php'; ?>


</div> <!-- END wrapOverall -->

</body>
</html>