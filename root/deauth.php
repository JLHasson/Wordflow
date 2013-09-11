<?php

ini_set('display_errors', 1);

$post = $_POST;

if(isset($post['deauthenticate']))
{
	
	require "mysql_server/checkuserlog.php";
	
	// deauthenticate id here.
	
	$results = deauthenticate($_SESSION['id'])->get_obj();
	
	if($results)
	{
		header('LOCATION: edit_profile.php');
	}
	
}
else
{
	header('LOCATION: index.php');
}