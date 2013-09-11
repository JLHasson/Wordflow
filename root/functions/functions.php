<?php 

/*
 * Generic Functions for Doing Stuff.
 *
 *
 *
 */
 
function email_activation($name, $email, $hash)
{
	$message = "Welcome to Word Flow! We are excited to have you sign up. Please click the link below to activate your account.";
	$message .= '  http://word-flow.com/activation.php?email='.$email.'&hash='.$hash;
	
	mail($email, "Hello $name! Activate your account.", $message,'From: do-not-reply@word-flow.com');
}

function generate_hash($token)
{
	return md5($token . mt_rand(0,1000));
}

function prevent_curl_requests()
{
	$server = $_SERVER['HTTP_HOST'];
	
	$curl_request = "Sorry you dont have permission to access this page.";
	
	if($server !== "word-flow.com") die($curl_request);
}