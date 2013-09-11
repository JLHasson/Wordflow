<?php
if ($_POST['parse_var'] == "bio"){
	
	$bio_body = $_POST['bio_body'];
	$bio_body = str_replace("'", "&#39;", $bio_body);
	$bio_body = str_replace("`", "&#39;", $bio_body);
    $bio_body = mysql_real_escape_string($bio_body);
    $bio_body = nl2br(htmlspecialchars($bio_body));
	 // Update the database data now here for all fields posted in the form
	 $sqlUpdate = mysql_query("UPDATE myMembers SET bio_body='$bio_body' WHERE id='$id' LIMIT 1");
     if ($sqlUpdate){
            $success_msg = '<img src="images/round_success.png" width="20" height="20" alt="Success" />Your description information has been updated successfully.';
     } else {
		    $error_msg = '<img src="images/round_error.png" width="20" height="20" alt="Failure" /> ERROR: Problems arose during the information exchange, please try again later.</font>';
     }
}
?>