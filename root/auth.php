<?php

/*
 * Word of Mouth Authentication Page
 *
 *
 * License here
 *
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word of Mouth Inc
 * @license 	website license here
 *
 */

include_once "mysql_server/checkuserlog.php";

// simple alias for the post global 

$post = $_POST;

$facebook = (object) config::get_instance()->get('facebook');

/*
 * Check to see if the signed request exists. if so do something if not kill it.
 */

if(isset($post['signed_request']))
{
	$response = parse_signed_request($post['signed_request'], $facebook->app_secret);
	
	if($response)
	{
	
		$database = database_crud::get_instance();
		
		$user = (object) $response['registration'];
		
		if(!$database->email_exists($user->email))
		{
			
			$first = strip_tags($user->first_name);
			
			$last 	= strip_tags($user->last_name);
			
			$email = strip_tags($user->email);
			
			$password = md5(strip_tags($user->password));
			
			// everything gets prepared anyways so it kills sql injections..
			
			$hash = generate_hash();
			
			if($database->create_member($first, $last, $email, $hash, $password))
			{
				
				$user = $database->query("SELECT `id` FROM `myMembers` WHERE `email` = :email", array(
					
					':email' => $email
					
				))->get_obj();
				
				if(isset($user->id))
				{
					mkdir("members/".$user->id, 0777);
				}
				else
				{
					// error log that user's file could not be created.
				}
				
				// email people here
				
				email_activation($first, $email, $hash);

				
				header("LOCATION: success.php?name=".$first);
			}
			else
			{
				header("LOCATION: register.php");
			}
			
		}
		else
		{
			header("LOCATION: register.php?form-error=1");
		}
		
		
		
	}
	else
	{
		header('LOCATION: register.php');	
	}
		
}
else
{	
	// Bye Bye..
	header('LOCATION: register.php');	
}
