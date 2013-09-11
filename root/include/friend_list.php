<?php
$friendList = '';

if(isset($_GET['id'])) {
	$getid = $_GET['id'];
} else {
	$getid = $_SESSION['id'];
}


if($friend_array!= "") {

		$friendArray = explode(",", $friend_array);
		$friendCount = count($friendArray);
		$friendArray = array_slice($friendArray, 0, 6);
		
		$friendList .= '
			<div style="margin-left:10px;">
				<div class="user_friends_header" style="float:left;">'. $firstname.'\'s Friends - ('.$friendCount.') </div>
				<div class="view_all_friends" style="float:right;">
					<a href="view_all_friends.php?id='.$getid.'">View All</a>
				</div>
			</div>
			
			<br />
			<hr style="margin:0px 5px 0px 5px;" />';
		$i = 0;
		$friendList .= '<div><table id="friendTable" align="left" cellspacing="5">';
		foreach($friendArray as $key => $value){
			$i++;
			$check_pic = 'members/'. $value .'/thumb_image01.jpg';
				if(file_exists($check_pic)){
					$friend_picture = '<a href = "profile.php?id='. $value .'"><img src="'. $check_pic .'" width="70" /></a>';
				} else {
					$friend_picture = '<a href = "profile.php?id='. $value .'"><img src="members/0/image01.jpg" width="70" /></a>';
				}
				
				$name_query = mysql_query("SELECT firstname, lastname FROM myMembers where id=$value LIMIT 1") or die("Sorry, Mysql Error");
				
				while($row= mysql_fetch_assoc($name_query)){ $friendFirstname = $row['firstname']; $friendLastname = $row['lastname']; }
				if ($i % 6 == 4){
				$friendList .= '<tr><td><div class="friends_box_name" style="width:70px; height:70px; overflow:hidden;" title="'. $friendFirstname . ' '. $friendLastname .'">
				' . $friend_picture . '
				</div></td>';  
			} else {
				$friendList .= '<td><div class="friends_box_name" style="width:70px; height:70px; overflow:hidden;" title="' . $friendFirstname . ' '. $friendLastname .'">
				' . $friend_picture . '
				</div></td>'; 
			}
									
		}
		$friendList .= '</tr></table></div>';
} else $friendList = "You don't have any friends yet! Search for them in the members tab to get started!";

?>