<?php

ini_set('display_errors', 1);

function email_activation($name, $email, $hash)
{	
	$message = "Welcome to Word of Mouth! We are excited to have you sign up. Please click the link below to activate your account.";

	$message .= '  http://word-flow.com/activation.php?email='.$email.'&hash='.$hash;
	
	mail($email, "Hello $name! Activate your account.", $message,'From: do-not-reply@word-flow.com');
}

header('LOCATION: index.php');