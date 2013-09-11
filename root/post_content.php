
<?php
include_once ("mysql_server/checkuserlog.php");

error_reporting(E_ALL);
ini_set("display_errors",'0');



// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------
if (isset($_SESSION['id'])) {
	 $id = $logOptions_id;
} 
 
$cacheBuster = rand(999999999,9999999999999);
//This code is used to display the logged in users information (ex. firstname lastname etc.)
$id = mysql_real_escape_string($id); 
$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");



// ------- START WHILE LOOP FOR GETTING THE MEMBER DATA ---------
while($row = mysql_fetch_array($sql)){ 
	extract($row);
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
	$last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));	
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"80px\" />"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
	}
	
	
	
}

//CHECK IF ID IS IN TABLE
//IF IT IS, DISPLAY THE REVIEW
//IF NOT, DISPLAY AN ERROR

$getId = $_GET['id'];
$checkTable = mysql_query("SELECT `review_id` FROM `reviews` WHERE review_id = '$getId'");
$num_rows = mysql_num_rows($checkTable);

if ($num_rows > 0) {
	
$outputList = '';
$getId = $_GET['id'];
$review_query = mysql_query("SELECT * FROM `reviews` WHERE review_id = '$getId'");

while($review_row = mysql_fetch_assoc($review_query)){
    					
    	$review_title = $review_row['review_title'];
    	$user_id = $review_row['user_id'];
    	$user_firstname = $review_row['user_firstname'];
    	$user_lastname = $review_row['user_lastname'];
    	$review_id = $review_row['review_id'];
    	$review_body = $review_row['review_body'];
    		    	
    	$review_date = $review_row['review_date'];
    		$review_date = date_create($review_date);
    		$review_date = date_format($review_date, 'F jS\, Y');
    	$user_firstname = $review_row['user_firstname'];
    	$review_rating = $review_row['review_rating'];
		
    	///////  Mechanism to Display Uploaded Pic. See if they have uploaded a pic or not  //////////////////////////
		$uploaded_pic = "members/$user_id/uploads/resized_$review_id.jpg";
			if (file_exists($uploaded_pic)) {
    			$uploaded_pic = "<img src=\"$uploaded_pic\" width=\"70%\" />"; 
			} else {
				$uploaded_pic = "No Photo was uploaded"; 
			}
				
    	///////  Mechanism to Display Profile Pic with Review. See if they have uploaded a pic or not  //////////////////////////
		$check_pic = "members/$user_id/thumb_image01.jpg";
		$default_pic = "members/0/image01.jpg";
			if (file_exists($check_pic)) {
    			$review_pic = "<img src=\"$check_pic\" width=\"80px\" />"; 
			} else {
				$review_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
			}
    	
		include_once('include/star_display.php');			




		//Pull the Review Category from the row
		$review_category = $review_row['review_category'];
		include_once('include/review_category.php');

		
		//Pull the Referral Category from the row
		$referral_category = $review_row['referral_category'];
		include_once('include/referral_category.php');
		
		//Code for URL for Each Review
		$review_url = $review_row['review_url'];
		if (!function_exists('remove_http')) {
	    	function remove_http($url = '') {
				return(str_replace(array('http://','https://'), '', $url));
			}
		}
        $review_url = remove_http($review_url);
   		$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
}
} else {
	$reviewNotFound = '';
	$reviewNotFound .= '
		<div style="margin:0px 0px 0px 20px;">
			<h1>Sorry, this review no longer exists.<br />We\'re sorry for the inconvenience.</h1>
		</div>
		<div class="returnHome" style="margin:0px 0px 0px 20px;">
			<a href="http://word-flow.com/home.php" id="homePageLink">
			<img src="images/left_arrow.png" width="14px" /> Return Home</a>
		</div>
	';
}
$commentOutput = '';
$comment = '';
$submit = '';

if ($_POST['parse_var'] == 'parse_var') {
	$toDelete = $_POST['toDelete'];
	mysql_query("DELETE FROM `comments` WHERE `id` = '$toDelete'");
	header ('location: post_content.php?id='.$getId.'');
	}


if(isset($_POST['submit'])) {
$getId = $_GET['id'];
$comment=$_POST['comment'];
$comment = stripslashes($comment); 
$comment = strip_tags($comment);
$comment = addslashes($comment);
$submit=$_POST['submit'];

if ($comment) {
    $commentQuery = mysql_query("INSERT INTO comments (user_id, review_id, comment_content, comment_date) VALUES ('$id','$getId','$comment', now())");
	header ('location: post_content.php?id='.$getId.'');
	}

}

$comment_query = mysql_query("SELECT * FROM `comments` WHERE review_id = '$getId'");
$commentCount = mysql_num_rows($comment_query);
while ($row3 = mysql_fetch_assoc($comment_query)) {
	$commentId = $row3['id'];
	$commenter = $row3['user_id'];
	$commentContent = $row3['comment_content'];
	$commentDate = $row3['comment_date'];
	$commentDate = date_create($commentDate);
    $commentDate = date_format($commentDate, 'F jS\, Y');
	
	$commentUserQuery = mysql_query("SELECT * FROM `myMembers` WHERE id = '$commenter'");

	$newcacheBust = rand(999999999,9999999999999);

	while ($row4 = mysql_fetch_assoc($commentUserQuery)) {
		$commenterid = $row4['id'];
		$commenterfirstname = $row4["firstname"];
		$commenterlastname = $row4["lastname"];
		
		$check_commenter_pic = "members/$commenterid/thumb_image01.jpg";
		$default_pic = "members/0/image01.jpg";
		if (file_exists($check_commenter_pic)) {
			$commenter_pic = "<img src=\"$check_commenter_pic?$newcacheBust\" width=\"50px\" />"; 
		} else {
			$commenter_pic = "<img src=\"$default_pic\" width=\"50px\" />"; 
		}
		$commentername = $commenterfirstname.' '.$commenterlastname;
		$deleteComment = '';
			if ($_SESSION['id'] == $commenterid) {
				$deleteComment = '<div align="right"><form method="POST" action=""><input type="hidden" name="parse_var" value="parse_var" /><input type="hidden" name="toDelete" value="'.$commentId.'" /><input type="image" width="15px" alt="Submit button" name="deleteComment" src="images/delete_button.png" /></form></div>';
			}

	}
	
	$commentOutput .= '
		<table style="background-color: #FFFFFF; border:1px solid #EEEEEE;" width="100%">
			<tr>
				<td style="float:left; width:20%;" class="review_user_name">
					<a href="profile.php?id='. $commenter .'">'.$commentername.'</a><br />
					'.$commenter_pic.'
				</td>
				
				<td style="float:right; width:78%; margin:5px 0px 2px 0px;">
				<div style="float:left;">'.$commentContent.'</div>'.$deleteComment.'<br /><br /><br /><span style="float:right; margin:0px 10px 0px 0px;font-size:12px; color:#CCCCCC;">'.$commentDate.'</span>
				</td>
			</tr>
		</table>
		<hr />
	';
	
	if($commentCount == 0){
						$commentNumber = 'Be the first to comment!';
					} else {
						$commentNumber = ''.$commentCount.' Comments Posted. Newest On Top';
					} 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta name="Description" content="Profile for <?php echo "$firstname, $lastname"; ?>" />
<meta name="Keywords" content="<?php echo "$firstname, $lastname, $city, $state, $country"; ?>" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Home Page for <?php echo "$firstname $lastname" ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="https://github.com/ericclemmons/de-pagify/raw/master/depagify.jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="scrollpagination.js" type="text/javscript"></script>
</head>
<body>

<?php include_once 'templates/header_template.php'; ?>
<?php include_once 'templates/sidebar_template.php'; ?>
<div id="fb-root"></div>

<div class="wrapOverall">

	

    <?php
	$getId = $_GET['id'];
	$checkTable = mysql_query("SELECT review_id FROM `reviews` WHERE review_id = '$getId'");
	$num_rows = mysql_num_rows($checkTable);
	if (isset($_SESSION['id'])) {
	 	$commentFull = '<div class="commentBox">
					<form action="" method="POST">
						<textarea name="comment" cols="80%" rows="2" title="Comment.." placeholder="Comment.." onkeyup="sz(this);" style="resize: none;"></textarea><br />
						<input type="submit" name="submit" value="Comment" /><br />
					</form>
				</div>';
	} else {
	 	$commentFull = 'You must log in to comment!';

	}
	
	
	if ($num_rows > 0) {
		
					echo '
        <div class="contentLeft">
			<div class="postContent" style="margin-top:30px;">
				<table id="'.$review_id.'" style="width:100%;">
                  	<tr>
                  	<td valign="top" style="float:left; width:15%; border-right:1px solid #DDDDDD; margin:5px 0px 5px 0px;">
                  		<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
						<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
					</td>
                  	<td style="float:right; width:82%;">
                  		<span class="review_stars">'. $review_stars .'</span>
                  		<div class="review_title_p">
                  			<p><span class="review_title">'. $review_title .'</span><span class="review_date_p">'. $review_date .'</span></p>
                  		</div>
                  		<div class="review_read_more">
                  			<p class="review_body_p">'. $review_body .'</p><br />
                  				<div>
                  					<div style="float:left;" class="review_black_font_link">Website:'.$review_url.'</div>
                  					<div style="float:right; margin-right:20px;" class="review_black_font_link">Category: '.$review_category_post .''.$referral_category_post.'</div>
                  				</div>
                  		</div>
                  		
                  	</td>
                  	</tr>
                  	<tr>
                  	<td>
						<hr style="margin:0px 5px 0px 5px;"/>
						<div class="uploadedPicture" align="center">
							'.$uploaded_pic.'
						</div>
					</td>
					</tr>			
            	</table>
			</div>
		
			<hr style="margin:0px 5px 0px 5px;"/>
			<div class="commentContainer">
				<div>'.$commentNumber.''.$commentOutput.'</div>
	
				'.$commentFull.'
				
			</div>
			</div> <!-- END contentleft -->
				';
		} else {
			echo '<div class="contentLeft">'.$reviewNotFound.'</div>';
		}?>
		   
        
        

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////LEFT COLUMN ABOVE////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////RIGHT COLUMN BELOW///////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
--><!-- This will contain profile information, friends box, as well as advertising -->

<!-- This is the Profile Code -->
        <div class="contentRight">
			
        		<div class="userMain">	
        			
        			<div class="userPic">
        			
        				<a href="profile.php?id=<?php echo $id; ?>"><?php print "$user_pic"; ?></a>
        			
        			</div> <!-- END userPic -->
        		
        			<table class="userInfo">
        				
        				<tr class="userName">
        				<td>
        				
        						<a class="userNameLink" href="profile.php?id=<?php echo $id; ?>"><?php print "$firstname $lastname"; ?></a><br />
        			
        				<td>
        				</tr> <!-- END userName -->
        				<tr>
        					<td>
        						<div class="userInbox">
        							
        							<a href="inbox.php">Inbox
        				
        							<?php echo $PM_envelope ;?>
        							
        							</a>
        						</div><!-- END userInbox -->
        				
        					</td>		
        				</tr> 
						
						<br />
				
					</table> <!-- END userInfo -->
		
				</div> <!-- END userMain -->
				
<!-- This is the Friends box code -->
		<hr style="margin-left:5px; margin-right:5px;"/>
		<div class="home_page_friends_box" style="width:270px; height:200px;">
		<?php
 // -------- CODE TO DISPLAY FRIENDS BOX -------
include_once ('include/friend_list_session.php');
?>
		<?php echo $friendList ?>
		</div>
<!-- This is the links to stores box -->
		<hr style="margin-left:5px; margin-right:5px;"/>
		<div class="#" style="width:270px;">
			<div class="black_text" style="font-size:16px; margin-left:5px;">
				Friend Didn't Post A Link?<br/>
			</div>
			
			<div class="black_text" style="font-size:14px; margin-left:5px;">
				That's alright, check out these sites <br/>
				to find what you're looking for!<br />
			</div>
			<hr style="margin-left:5px; margin-right:5px;"/>
			<div class="externalLinks" style="font-size:14px; margin-left:5px;">
				<a href="http://www.amazon.com/" target="_BLANK">Amazon</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
				<a href="http://www.overstock.com/" target="_BLANK">Overstock</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
				<a href="http://www.target.com/" target="_BLANK">Target</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
				<a href="https://newegg.com/" target="_BLANK">Newegg</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
				<a href="http://www.buy.com/" target="_BLANK">Buy.com</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
			</div>

		</div>
<!-- This is the Advertisements code -->
		<div class="advertisements_box" style="font-size:18px; margin-left:5px;">
		Advertisements: <br /><br />
		
		<br /><br />
		
		</div>
		
	</div> <!-- END contentRight -->
	
<!-- FOOTER -->
	<div class="footer">
	<?php include_once 'templates/footer_template.php'; ?>
	</div>

</div> <!-- END wrapOverall -->

</body>

</html>