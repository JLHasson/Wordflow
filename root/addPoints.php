<?php 

	$result1=mysql_query("UPDATE myMembers SET pointSystem = (`pointSystem` + 100) WHERE `id` = '$user_id'");
	$result2=mysql_query("UPDATE myMembers SET pointActive = (`pointActive` + 100) WHERE `user_id` = '$user_id'");
	$result3=mysql_query("UPDATE myMembers SET fbShare = 0 WHERE `user_id` = '$user_id'");

}?>