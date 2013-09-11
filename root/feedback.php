<?php

include_once "mysql_server/checkuserlog.php";

if (isset($_POST['feedbackSubmit'])) {
	$ERROR = "";
	$humanCheck = $_POST['humanCheck'];
	if ($humanCheck != "") {
		$ERROR = "Please erase all the text to prove you are human.";
	} else {
	$text = $_POST['feedbackText'];
	$to = "info@word-flow.com";
	$subject = "Word of Mouth Feedback";
	
	$text = stripslashes($text);
	$text = htmlentities($text);
	$text = strip_tags($text);
	}
	if(mail($to, $subject, $text)){
		header("location: http://word-flow.com/thank_you.php");
	} else {
		$ERROR = "Message was not sent! Sorry!";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Feedback Page" />
<meta name="Keywords" content="fill, in, information, feedback" />
<meta name="rating" content="General" />
<title>Give us feedback!</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>

	<?php include_once 'templates/header_template.php'; ?>
	
    <div class="wrapOverall">
		<script type='text/javascript'>
			var textValue = "<?php echo $_POST['feedbackText']; ?>";
			$('feedbackText').val(textValue);
			document.write(textValue);
		</script>

	



        <div class="contentMain">   
			<div class="feedback" id="feedback">
				<div class="feedbackHeader">
					<h1>We want to know what you think!</h1>
					<p class="feedbackPara">Here at Word of Mouth we care about what you have to say. We're still early in the development stage</br>
						and still have many more things to come and we want you to help guide us in the right direction!</br>
						Below we've provided a form to allow you to give us feedback. We read over everything that's submitted,</br>
						so please take the time to let us know what you think, what you like, or dislike about the site, and </br>
						what we could be doing better.</p>
				</div>
				<p class="errorMessage"><?php echo $ERROR; ?></p>
				<div class="feedbackForm" id="feedbackForm">
					<form class="feedbackForm" name="feedbackForm" action="http://word-flow.com/feedback.php" method="Post">
						<label name="feedbackTextLabel" for="feedbackText">Your feedback here: </br></label>
						
						<textarea class="feedbackText" name="feedbackText" cols="75" rows="25"></textarea><br><br>
						
						<label name="feedbackTextLabel" for="humanCheck">Human Check:</label><br><br>
						
						<input type="text" style="width:150px;" name="humanCheck" class="humanCheck" value="Please delete all this text" /><br><br>
						
						<input type="submit" name="feedbackSubmit" class="feedbackSubmit" value="Submit!" />
					</form>
				</div> <!--END FEEDBACKFORM -->
			</div> <!--END FEEDBACK -->       
		</div> <!--END CONTENT MAIN -->

		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>