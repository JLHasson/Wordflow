<?php


// we would retrieve the user's object via the graph but im going to cheat a little and just plug in my user id


$token = 'AAACEdEose0cBAEK7U9BbZA1Njl6G8aLSjymPjX4K0jmQychv3N5Y3XBNrh4mP4iI2OlxkTy4pkzVCZAwdGMpjQ6E9BD3bKNoTEgbuakhlNu2g90rlZB';



function get_facebook_friends($token)
{

	$base = "https://graph.facebook.com/fql?q=SELECT+uid2+FROM+friend+WHERE+uid1=me()&access_token=" . $token;
	
	$curl = curl_init($base);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	$results = curl_exec($curl);
	
	curl_close($curl);
	
	return $results;

}

function find_app_friends($token)
{
	$friends = json_decode(get_facebook_friends($token));
	
	$friends = $friends->data;
	
	echo count($friends);
	
	echo "<br>";
	
	foreach($friends as $friend)
	{
		$sql = "SELECT `id` FROM `myMembers` WHERE `facebook_id` = ".$friend->{'uid2'};
		
		
		
		echo $sql . "<br>";
	}
}

find_app_friends($token);