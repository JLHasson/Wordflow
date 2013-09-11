<?php


// deauthenticate from facebook page


function deauthenticate($id)
{
	
	$database = database_crud::get_instance();
	
	$sql = "UPDATE `myMembers` SET `access_token` = '0', `facebook_id` = '0' WHERE `id` = :id";
	
	return $database->query($sql, array(
	
		':id' => $id
	
	));
}