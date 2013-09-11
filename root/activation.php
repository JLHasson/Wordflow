<?php

ini_set('display_errors', 1);

require 'mysql_server/checkuserlog.php';

if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash']))
{
	$database = database_crud::get_instance();
	
	$email = strip_tags($_GET['email']);
	
	$hash = strip_tags($_GET['hash']);
	
	$results = $database->query("UPDATE `myMembers` SET `email_activated` = '1' WHERE `email` = :email AND `email_hash` = :hash", array(
	
		':email' => $email,
		':hash'  => $hash
	
	))->get_obj();
	
	
	$msgToUser = "Welcome to Word Flow! Your account is now activated! You may now login to Word Flow for the first time.";
	
}
else
{
	$msgToUser = "If you are trying to activate your account, please do not change the link that was included in the email.";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Template Page" />
<meta name="Keywords" content="fill, in, information" />
<meta name="rating" content="General" />
<title>Word of Mouth | Activation</title>
<link href="style.css" rel="stylesheet" type="text/css" />

<link rel="icon" href="#" type="image/x-icon" /> <!-- INSERT ICON -->

<link rel="shortcut icon" href="#" type="image/x-icon" /> <!-- AND HERE -->

</head>
<body>

    <?php include_once 'templates/header_template.php'; ?>
    
    <div class="wrapOverall">


        <div class="contentLeft" width="690" height="1000px" align="left" cellpadding="8" cellspacing="0">          
        <?php echo $msgToUser; ?>
        </div>

        <?php include_once 'templates/footer_template.php'; ?>


    </div> <!-- END wrapOverall -->

</body>
</html>