<?php

function parse_signed_request($signed_request, $secret) {
  
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
} 



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

function deauthenticate($id)
{
	
	$database = database_crud::get_instance();
	
	$sql = "UPDATE `myMembers` SET `access_token` = '0', `facebook_id` = '0' WHERE `id` = :id";
	
	return $database->query($sql, array(
	
		':id' => $id
	
	));
}