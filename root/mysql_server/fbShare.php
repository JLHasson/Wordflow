<?php 
	if ($fbShare == 1) {
	$query1 = "UPDATE `myMembers` SET `pointSystem` = (`pointSystem` + 100) WHERE `id` = '$user_id'";
	$result1=mysql_query($query1);

	$query2 = "UPDATE `myMembers` SET `pointActive` = (`pointActive` + 100) WHERE `id` = '$user_id'";
	$result1=mysql_query($query2);

}?>