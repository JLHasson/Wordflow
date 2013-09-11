<?php


require 'mysql_server/checkuserlog.php';

$post = $_POST;

$facebook = (object) config::get_instance()->get('facebook');

if(isset($post['authenticate']))
{
	
	$url = 'https://www.facebook.com/dialog/oauth?client_id='.$facebook->app_id.'&redirect_uri='.urlencode("http://word-flow.com/fb.php").'&scope=publish_stream';
	
	header('LOCATION: '.$url);
	
}
else
{
	if(isset($_GET['code']))
	{
		$responseUrl = "https://graph.facebook.com/oauth/access_token?client_id=".$facebook->app_id."&redirect_uri=".urlencode("http://word-flow.com/fb.php")."&client_secret=".$facebook->app_secret."&code=".$_GET['code'];
		
		// curl not file_get_contents
		
		$c = curl_init($responseUrl);
		
		curl_setopt($c, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		
		$token = curl_exec($c);
		
		curl_close($c);
	
		
		$params = null;
		
		parse_str($token, $params);
		
		if(isset($params['access_token']))
		{
			$sql = mysql_query("UPDATE `myMembers` SET `access_token` = '".$params['access_token']."' WHERE `id`= ".$_SESSION['id']." LIMIT 1");
			
			if($sql)
			{
				//header('LOCATION: edit_profile.php');
			}
			else
			{
				echo "There was a problem storing the access token in the database.";
			}
			
		}
	}
	else
	{
		//header('LOCATION: edit_profile.php');
	}
}