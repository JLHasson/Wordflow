<?php

/*
 * Post to Facebook
 *
 * 
 */
 
 
 
 
$post = $_POST; 

$access_token = "12345";

$url = "me/feed";

$id = "";

$source = "";

$icon = "";

$actions = "";

$privacy = "";

$place = "";

$data = array(

	'access_token' => $database->get('access_token'), // access token required 
	
	'message' => $post['message'], // message required
	
	'link' => ,
	
	'picture' => "http://word-flow.com/images/WordflowIcon.png",

);

function post2facebook($url, $data)
{
	$base = "https://graph.facebook.com/" . $url;
	
	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_USERAGENT, "Wordflow");
	
	curl_setopt($curl, CURLOPT_POST, 1);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	
	$results = curl_exec($curl);
	
	curl_close($curl);
	
	return $results;
	
}