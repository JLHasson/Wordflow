<?php 

function has_friend_request($id) // pre-sanitized id
{
	$sql = "SELECT `id` FROM friends_requests WHERE `mem2` = '$id' LIMIT 1"; // return as little data as we have too.
	
	$rows = mysql_num_rows(mysql_query($sql) or die("Mysql Error - Could not fetch friend requests."));
	
	return ($rows > 0) ? true : false;
}

function get_friend_requests($id)
{
	$sql = "SELECT * FROM `friends_requests` WHERE `mem2` = '$id' LIMIT 50";
	
	
	
	
}

function requester($id)
{
	$sql = "SELECT `firstname`, `lastname` FROM `myMembers` WHERE `id` = '$id' LIMIT 1";
	
	$person = mysql_query($sql) or die("MySql Error - Could not fetch people who have friended you.");
	
	// no need for the while loop since its only one result ;)
	
	return mysql_fetch_assoc($person);
}


    						$sql = "SELECT * FROM friends_requests WHERE mem2='$id' ORDER BY id ASC LIMIT 50";
    						
							$query = mysql_query($sql) or die ("Sorry we had a mysql error!");
							
							$num_rows = mysql_num_rows($query); 
							
							if ($num_rows < 1) {
							
								echo 'You have no Friend Requests at this time.';
								
							} else {
							
        					while ($row = mysql_fetch_array($query)) { 
        					
		    					$requestID = $row["id"];
		    					
		    					$mem1 = $row["mem1"];
		    					
	        					$sqlName = mysql_query("SELECT * FROM myMembers WHERE id='$mem1' LIMIT 1") or die ("Sorry we had a mysql error!");
		    					while ($row = mysql_fetch_array($sqlName)) { 
		    					
		    						$requesterFirstName = $row["firstname"];
		    						 
		    						$requesterLastName = $row["lastname"];
		    						
		    					}
		    					
		    					///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
		    					
		    					$check_pic = 'members/' . $mem1 . '/image01.jpg';
		    					
		    					if (file_exists($check_pic)) {
		    					
									$lil_pic = '<a href="profile.php?id=' . $mem1 . '"><img src="' . $check_pic . '" width="50px" border="0"/></a>';
		    					} else {
		    					
									$lil_pic = '<a href="profile.php?id=' . $mem1 . '"><img src="members/0/image01.jpg" width="50px" border="0"/></a>';
		    					}
		    					
		    					echo	'<hr />
		    					
								<table width="100%" cellpadding="5">
									<tr>
										<td width="17%" align="left">
											<div style="overflow:hidden; height:50px;"> ' . $lil_pic . '</div>
										</td>
                        				
                        				<td width="83%">
                        				<a href="profile.php?id=' . $mem1 . '">' . $requesterFirstName . ' ' . $requesterLastName .'</a> wants to be your Friend!<br /><br />
					    					
					    					<span id="req' . $requestID . '">
					   					
					   							<!-- Accept -->
					   							<a href="#" onclick="return false" onmousedown="javascript:acceptFriendRequest(' . $requestID . ');" >Accept</a>
					    					
					    						&nbsp; &nbsp; OR &nbsp; &nbsp;
					    				
					    						<!-- Deny -->
					    						<a href="#" onclick="return false" onmousedown="javascript:denyFriendRequest(' . $requestID . ');" >Deny</a>
					    					</span>
					    				</td>
                        			</tr>
                      			</table>';
       							}	 
							}
    						?>