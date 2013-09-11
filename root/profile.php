<?php
session_start();

include_once("mysql_server/checkuserlog.php");

// Now let's initialize vars to be printed to page in the HTML section so our script does not return errors 
// they must be initialized in some server environments, not shown in video
$error_msg = ""; 
$errorMsg = "";
$success_msg = "";
$firstname = "";
$lastname = "";
$bio_body = "";
$user_pic = "";
$referralDisplayList = "";
$interactionBox= "";
// If coming from other page
if (isset($_GET['id'])) {
	
     $id = $_GET['id'];
     
} else if (isset($_SESSION['id'])) {
	
	 $id = $logOptions_id;

} else { 

   include_once "welcome.php";

   exit();
}



$id = mysql_real_escape_string($id); 
$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");
$noMem = mysql_num_rows($sql);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

// WHILE LOOP FOR DISPLAYING MEMBER DATA

while($row = mysql_fetch_array($sql)){ 
	extract($row);
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	$pointSystem = $row['pointSystem'];
	$pointActive = $row['pointActive'];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"218px\" >"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"218px\" />"; 
	}
	
	
}

if(isset($_SESSION['id']) && $_SESSION['id'] !=$id) {

	$sqlArray = mysql_query("SELECT friend_array FROM myMembers WHERE id='". $_SESSION['id'] . "' LIMIT 1"); 
		while($row=mysql_fetch_array($sqlArray)) { $iFriend_array = $row["friend_array"]; }
		 $iFriend_array = explode(",", $iFriend_array);
		if (in_array($id, $iFriend_array)) { 
		$messageIcon = '<div class="messageOpenButton" id="OpenButton" >
		<div style="float:right;">
		 <a href="#" id="toggleMessageBox">	
			<div class="black_text" style="float:left; margin:6px 5px 0px 0px;">Message Me!</div>
			
			<div style="float:right;">
					<img title="Message" src="images/header/mail.png" height="30px" />
				
			</div>
		 </a>
		</div>
		</div> <!-- END messageOpenButton -->
		
		<div id="interactionResults" style="font-size:15px; padding:10px;"></div>
        
        <div class="interactContainers" id="messages" display: none;">
        	
        	<form action="javascript:sendPM();" name="pmForm" id="pmForm" method="post">
			
				<font size="+1">Compose Message to <strong>'. $firstname .' '. $lastname .'</strong><br /><br />
				Subject:
				<input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;" />
				Message:
				<textarea name="pmTextArea" id="pmTextArea" rows="8" style="width:98%;"></textarea>
				<input name="pm_sender_id" id="pm_sender_id" type="hidden" value="'. $_SESSION['id'] .'" />
				<input name="pm_sender_name" id="pm_sender_name" type="hidden" value="'. $_SESSION['firstname'] .'" />
				<input name="pm_rec_id" id="pm_rec_id" type="hidden" value="'. $_GET['id'] .'" />
				<input name="pm_rec_name" id="pm_rec_name" type="hidden" value="'. $firstname .'" />
				<br />
				<input id="submitMessageBox" name="pmSubmit" type="submit" value="Submit" /><div class="black_text_close"><a href="#" id="closeMessageBox">Close</a></div>
				<span id="pmFormProcessGif" style="display:none;"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
        	
        	</form>
      
        </div>';
		$interactionBox = '<div>
								<span class="blue_text">
								<a href="#" id="display_confirm_delete">Remove Friend</a>
					   	   		</span>
					   	   		
					   	   </div>';
		} else {
		$interactionBox = '<div>
						<span class="blue_text">
						<a href="#" id="display_confirm_link">Add as Friend</a>
						</span>
												   
					   </div>';
		$messageIcon = '<div class="messageOpenButton" id="OpenButton" >
		<div style="float:right;">
		 <a href="#" id="toggleMessageBox">	
			<div class="black_text" style="float:left; margin:6px 5px 0px 0px;">Message Me!</div>
			
			<div style="float:right;">
					<img title="Message" src="images/header/mail.png" height="30px" />
				
			</div>
		 </a>
		</div>
		</div> <!-- END messageOpenButton -->
		
		<div id="interactionResults" style="font-size:15px; padding:10px;"></div>
        
        <div class="interactContainers" id="messages" display: none;">
        	
        	<form action="javascript:sendPM();" name="pmForm" id="pmForm" method="post">
			
				<font size="+1">Compose Message to <strong>'. $firstname .' '. $lastname .'</strong><br /><br />
				Subject:
				<input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;" />
				Message:
				<textarea name="pmTextArea" id="pmTextArea" rows="8" style="width:98%;"></textarea>
				<input name="pm_sender_id" id="pm_sender_id" type="hidden" value="'. $_SESSION['id'] .'" />
				<input name="pm_sender_name" id="pm_sender_name" type="hidden" value="'. $_SESSION['firstname'] .'" />
				<input name="pm_rec_id" id="pm_rec_id" type="hidden" value="'. $_GET['id'] .'" />
				<input name="pm_rec_name" id="pm_rec_name" type="hidden" value="'. $firstname .'" />
				<br />
				<input id="submitMessageBox" name="pmSubmit" type="submit" value="Submit" /><div class="black_text_close"><a href="#" id="closeMessageBox">Close</a></div>
				<span id="pmFormProcessGif" style="display:none;"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
        	
        	</form>
      
        </div>';
	}
	} else if(isset($_SESSION['id']) && $_SESSION['id'] == $id){
	
		$interactionBox = '<div>
						<span class="blue_text">
						<a href="inbox.php">Inbox</a><br />
						<a href="#" id="friends_requests">Friend Requests</a><br />
					   <a href="edit_profile.php">Edit Profile</a>
					   </span>
					   </div>';
	
	} else {
	$interactionBox = '<a href="welcome.php">Login</a> or <a href="register.php">Sign Up</a> to Friend Request!';
}

if (isset($_POST['parse_var']) && $_POST['parse_var'] == "delete_post"){
	$review_delete_id = $_POST['review_get_id'];
	$sql_delete = mysql_query("DELETE FROM reviews WHERE `review_id`='$review_delete_id'");

}
//Code for Friends List
include_once('include/friend_list.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta name="Description" content="Profile for <?php echo "$firstname, $lastname"; ?>" />
<meta name="Keywords" content="<?php echo "$firstname, $lastname, $city, $state, $country"; ?>" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Word of Mouth | <?php echo "$firstname $lastname" ?>'s Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="#" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="#" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
//Toggle Message Box
	$('.interactContainers').hide();
	$('.messageOpenButton').show();
	
	$('#toggleMessageBox').click(function () {
		$('.interactContainers').slideToggle();
		return false;
	});
	$('#closeMessageBox').click(function () {
		$('.interactContainers').slideToggle();
		return false;
	});

    //Toggle Change Bio Box	
	$('.editBioBox').hide();
	$('.bioBody').show();
	$('.changeBio').show();
	
	$('#showBio').click(function () {
		$('.editBioBox').slideToggle();
		return false;
	});
	
	$('#updateBtn4').click(function() {
		$('.editBioBox').slideToggle();
	});



	//Add as Friend
	$('.add_friend').hide();
	$('.display_confirm').show();
	
	$('#display_confirm_link').click(function () {
		$('.add_friend').slideToggle();
		return false;
	});
	$('#close_confirm').click(function () {
		$('.add_friend').slideToggle();
		return false;
	});
	
	//Friend Requests
	$('.friend_request').hide();
	$('.display_confirm').show();
	
	$('#friends_requests').click(function () {
		$('.friend_request').slideToggle();
		return false;
	});
	
	//Remove as Friend
	$('.remove_friend').hide();
	$('.display_confirm').show();
	
	$('#display_confirm_delete').click(function () {
		$('.remove_friend').slideToggle();
		return false;
	});
	$('#close_confirm_delete').click(function () {
		$('.remove_friend').slideToggle();
		return false;
	});
	$('#askQuestionDropDown').click(function() {
		$('#three').slideToggle();
		$('#two').hide();
		$('#one').hide();
	});
	$('#boughtItDropDown').click(function() {
		$('#three').hide();
		$('#two').slideToggle();
		$('#one').hide();
	});
	$('#referalDropDown').click(function() {
		$('#three').hide();
		$('#two').hide();
		$('#one').slideToggle();
	});
});
$('#pmForm').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function sendPM() {
      var pmSubject = $("#pmSubject");
	  var pmTextArea = $("#pmTextArea");
	  var sendername = $("#pm_sender_name");
	  var senderid = $("#pm_sender_id");
	  var recName = $("#pm_rec_name");
	  var recID = $("#pm_rec_id");
	  var url = "messaging_parse.php";
      if (pmSubject.val() == "") {
           $("#interactionResults").html('<img src="../../images/error.png" alt="Error" width="31" height="30" /> &nbsp; Please type a subject.').show().fadeOut(6000);
      } else if (pmTextArea.val() == "") {
		   $("#interactionResults").html('<img src="../../images/error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your message.').show().fadeOut(6000);
      } else {
		   $("#pmFormProcessGif").show();
		   $.post(url,{ subject: pmSubject.val(), message: pmTextArea.val(), senderName: sendername.val(), senderID: senderid.val(), recName: recName.val(), recID: recID.val() } ,          
		   
		    function(data) {
			   $('#private_message').slideUp("fast");
			   $("#interactionResults").html(data).show().fadeOut(10000);
			   document.pmForm.pmTextArea.value='';
			   document.pmForm.pmSubject.value='';
			   $("#pmFormProcessGif").hide();
           });
	  }
}

var friendRequestURL = "request_as_friend.php";
var thisRandNum = "<?php echo $thisRandNum; ?>";
function addAsFriend(a,b) {
	$("#add_friend_loader").show();
	$.post(friendRequestURL,{ request: "requestFriendship", mem1: a, mem2: b ,thisToken: thisRandNum } ,function(data) {
	    $("#run_php").html(data).show().fadeOut(12000);
    });	
}
function acceptFriendRequest (x) {
	$.post(friendRequestURL,{ request: "acceptFriend", reqID: x, thisToken: thisRandNum } ,function(data) {
            $("#req"+x).html(data).show();
    });
}
function denyFriendRequest (x) {
	$.post(friendRequestURL,{ request: "denyFriend", reqID: x, thisToken: thisRandNum } ,function(data) {
           $("#req"+x).html(data).show();
    });
}
function removeAsFriend(a,b) {
	$("#remove_friend_loader").show();
	$.post(friendRequestURL,{ request: "removeFriendship", mem1: a, mem2: b, thisToken: thisRandNum } ,function(data) {
	    $("#delete_friend").html(data).show().fadeOut(12000);
    });	
}
</script>
<style>
#remove_friend_loader {
	display:none;
}
#add_friend_loader {
	display:none;
}
</style>
</head>
<body>

	<?php include_once 'templates/header_template.php'; ?>
	<?php include_once 'templates/sidebar_template.php'; ?>
<div class="wrapOverall">
	<?php if ($noMem === 0) {
	echo '
		<script type="text/javascript">
			$(function() {
			$(".profileTable").hide();
			document.title = "ERROR";
			});
		</script>
		<h1>Oops! This person doesn\'t exist in our database! <br/>Please try a different user.</h1>
	';
}
?>
<table id="profileTable" class="profileTable" width="980px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="980"><br />
      <table width="90%" border="0" align="center" cellpadding="6">
      	<tr>
        	<td width="28%" valign="top">
				<span style="font-size:32px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
					<?php print "$firstname $lastname"; ?><br />
					
				</span>
        		
        		<br />
        		
				<div class="profilePicIcon">
				
					<?php echo "$user_pic"; ?>
        		
        		</div>
        			<br />
    	
				<!-- This is the code to be set if the user wants to add as a friend, and will display "already friends" as well as friend requests -->
				<div id="display_confirm"><?php echo $interactionBox; ?></div>
	
				<div class="add_friend" id="run_php">
                	Add <?php echo "$firstname"; ?>  as a friend?
                	
                	<div class="blue_text"> <a href="#" onclick="return false" onmousedown="javascript:addAsFriend(<?php echo $_SESSION['id']; ?>, <?php echo $_GET['id']; ?>);">Yes</a> </div>
                	
                	<span id="add_friend_loader">
                		<img src="images/loading.gif" width="28" height="10" alt="Loading" />
                	</span>
        		
        			<div align="left" class="blue_text" ><a href="#" id="close_confirm">Cancel</a> </div>
        		</div>
        
        		<div class="friend_request" style="overflow:auto;">
        		
        			<h4>Only Accept True Friends:</h4>
        			
        				<?php include_once("include/accept_friend.php");?>
       			</div>
       			
       			<div class="remove_friend" id="delete_friend">
       				Are you sure you want to remove <?php echo "$firstname"; ?> from your friends list?<br />
       				
       				<div class="blue_text"> <a href="#" onclick="return false" onmousedown="javascript:removeAsFriend(<?php echo $_SESSION['id']; ?>, <?php echo $_GET['id']; ?>)">Yes</a> </div>
		
					<span id="remove_friend_loader"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>

        			<div align="left" class="blue_text"><a href="#" id="close_confirm_delete">Cancel</a></div>
        		</div>
				<br />
        		<hr />
        Member Since: <?php print "$sign_up_date"; ?>
        
        		<br />
        		<br />
        
        <strong><u>About <?php print "$firstname $lastname"; ?></u></strong>
        
        		<br />
		
		<div class="bioBody">
			
			<?php
		if($bio_body==''){
			 $bio_body = "";
			 } else {
			 print "$bio_body";
			 }
			 
			 ?>
		
		</div>
		
        		
   		<br />
   		Total Points Earned: <?php print "$pointSystem"; ?><br/>
        Points left to Spend: <?php print "$pointActive"; ?><br/>
		<hr />
    	<?php echo $friendList ?>
    </td>
    <td width="72%" valign="top" style="border-left:1px solid #DDDDDD;">
    
    
    
        <?php echo $messageIcon; ?>
        
        
		
        		<br />
		
				<strong><u><?php print "$firstname $lastname"; ?>'s Recent Activity:</u></strong>
        			
        		<br />
				<br />
		

			
			<div class="outputDiv">
			<?php 
	$review_query = mysql_query("SELECT * FROM `reviews` WHERE user_id='$id' ORDER BY `review_date` DESC LIMIT 4");		
	$review_num_rows = mysql_num_rows($review_query);
		
		if($review_num_rows == 0) {
			echo "<div class='black_text' style='font-size:24px; margin:30px 0px 0px 0px;'><center>Oops, No Reviews have been Written Yet!</center></div>";
		}
		while($review_row = mysql_fetch_assoc($review_query)){
    		
    			extract($review_row);
    	
    			// Code to append text for title
    			// strip tags to avoid breaking any html
				$review_title = strip_tags($review_title);

				if (strlen($review_title) > 30) {

   					// truncate string
   					$stringCut = substr($review_title, 0, 30);

    				// make sure it ends in a word so assassinate doesn't become ass...
    				$review_title = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
				}
    		
    			// Code to append text and add Read More
    			// strip tags to avoid breaking any html
				$review_body = strip_tags($review_body);

				if (strlen($review_body) > 230) {

   					// truncate string
   					$stringCut = substr($review_body, 0, 230);

    				// make sure it ends in a word so assassinate doesn't become ass...
    				$review_body = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a class="reviewContentLink" href="post_content.php?id='. $review_id .'">See Full Post</a>'; 
				} else {
					$review_body .= '<a class="reviewContentLink" href="post_content.php?id='. $review_id .'">See Full Post</a>';
				}
    	
    			
    			$review_date = date_create($review_date);
    			$review_date = date_format($review_date, 'F jS\, Y');
    			
    	
    	
    	
    		///////  Display Picture. See if they have uploaded a pic or not  //////////////////////////
			$check_pic = "members/$user_id/thumb_image01.jpg";
			$default_pic = "members/0/image01.jpg";
				if (file_exists($check_pic)) {
   					$review_pic = "<img src=\"$check_pic\" width=\"80px\" />"; 
				} else {
					$review_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
				}
				
    		//Pull the number of stars to be displayed
			include_once('include/star_display.php');			

			//Pull the Review Category from the row
			$review_category = "";
			$review_category = $review_row['review_category'];
			include('include/review_category.php');

		
			//Pull the Referral Category from the row
			$referral_category = "";
			$referral_category = $review_row['referral_category'];
			include('include/referral_category.php');

		
			//Code for URL for Each Review
			$review_url = $review_row['review_url'];
			if (!function_exists('remove_http')) {
	    		function remove_http($url = '') {
					return(str_replace(array('http://','https://'), '', $url));
				}
			}
        
        	if(isset($_SESSION['id']) && $_SESSION['id'] == $id){
	
					$deletePost = ' <form action="#" method="post" enctype="multipart/form-data">
                  					<input type="image" alt="submit button" src="images/delete_button.png" width="20px"/>
              						<input name="parse_var" type="hidden" value="delete_post" />
              						<input name="review_get_id" type="hidden" value="'.$review_id.'" />
                  				</form>';
	
			} 
		
			//CODE TO DISTINGUISH REFERRALS FROM REVIEWS			
			//Final Output List
			if($review_referral == 0) {
					//Code for Displaying URL Link
					$review_url = remove_http($review_url);
   					$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
    				
    					echo '
    					<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
                  			<table id="'.$review_id.'" style="width:98.5%; border:#00B347 1px solid; margin:10px 0px 20px 10px;">
                  			<td style="float:left; width:15%; border-right:1px solid #DDDDDD; margin:5px 0px 5px 0px;">
                  								<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
												<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
                  								<div class="bought_it_newsfeed">Bought It!</div>
                  					</td>
                  					<td style="float:right; width:82%;">
                  							<div style="float:right;">'.$deletePost.'</div>
                  							<div class="review_title_p">
                  								<p><span class="review_title">'. $review_title .'</span><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
                  							</div>
                  							<div class="review_read_more">
                  								<p class="review_body_p">'. $review_body .'</p><br />
                  								<div>
                  									<div style="float:left;" class="review_black_font_link">Website:'.$review_url.'</div>
                  									<div style="float:right; margin-right:20px;" class="review_black_font_link">Category: '.$review_category_post .'</div>
                  								</div>
                  							</div>
                  					</td>
                  					
                  			</table>
				  			<hr style="margin:0px 20px 0px 20px;" /> 	
				  			</div>
				  						';
				  				
				  } else if($review_referral == 1) {	
					//Code for Displaying URL Link
					$review_url = remove_http($review_url);
   					$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Click Here</a> ";
				  		
			  		echo '
    						<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
                  			<table id="'.$review_id.'" style="width:98.5%; border:#0099FF 1px solid; margin:10px 0px 20px 10px;">
                  			<td style="float:left; width:15%; border-right:1px solid #DDDDDD; margin:5px 0px 5px 0px;">
                  								<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
												<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
                  								<div class="referral_newsfeed">Referral</div>
                  					</td>
                  					<td style="float:right; width:82%;">
                  					        <div style="float:right;">'.$deletePost.'</div>
                  							<div class="review_title_p">
                  								<p><a href="post_content.php?id='. $review_id .'">'. $review_title .'</a><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
                  							</div>
                  							<div class="review_read_more">
                  								<p class="review_body_p">'. $review_body .'</p><br />
                  								<div>
                  									<div style="float:left;" class="review_black_font_link">Business Website:'. $review_url .'</div>
                  									<div style="float:right; margin-right:20px;" class="review_black_font_link">Category: '. $referral_category_post .'</div>
                  								</div>
                  							</div>
                  					</td>
                  					
                  			</table>
				  			<hr style="margin:0px 20px 0px 20px;" /> 	
				  			</div>
				  						';
				  }	}

				  ?>		</div> <!-- END outputDiv -->
				
			<div class="fullProfileContentDiv">
			<?php
			if (isset($_GET['id'])) {
			echo '<div class="viewAllPosts"><a href="profileContent.php?id='.$_GET['id'].'" id="viewFullProfileContent">View All of '.$firstname.' '.$lastname.'\'s Posts</a></div>';
			} else {
			echo '<div class="viewAllPosts"><a href="profileContent.php?id='.$_SESSION['id'].'" id="viewFullProfileContent">View All of '.$firstname.' '.$lastname.'\'s Posts</a></div>';
			}
			?>
			</div>

        		
				
        	</td>

      	</tr>  		
      </table>
      	</td>
  </tr>
</table>

	<?php include_once 'templates/footer_template.php'; ?>


</div> <!-- END wrapOverall -->

</body>

</html>
