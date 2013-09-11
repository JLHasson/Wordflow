<?php
include_once ("mysql_server/checkuserlog.php");


error_reporting(E_ALL);
ini_set("display_errors", 0);


// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------
if (isset($_SESSION['id'])) {
	$id = $logOptions_id;
} else {
    header("location: welcome.php");
    exit();
}


//This code is used to display the logged in users information (ex. firstname lastname etc.)
$id = mysql_real_escape_string($id); 
$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");





// ------- START WHILE LOOP FOR GETTING THE MEMBER DATA ---------
while($row = mysql_fetch_array($sql)){ 
	extract($row);
	$friend_array = $row['friend_array'];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));			
	$bio_body = str_replace("&amp;#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	$user_token = $row['access_token'];
	$pointSystem = $row['pointSystem'];
	$pointActive = $row['pointActive'];
	$fbShare = $row['fbShare'];
	$twitterFollow = $row['twitterFollow'];

	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/thumb_image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"80px\" />"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// -------- CODE TO DISPLAY FRIENDS BOX -------
include_once ('include/friend_list_session.php');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['user_id'])) {
$postMessage = "<span id='postMessage' class='blue_text'>";

//PHP SCRIPT FOR INSERING THE BOUGHT IT FORM INTO THE DATABASE
	$user_id = $_POST["user_id"];
	$user_firstname = $_POST["user_firstname"];
	$user_lastname = $_POST["user_lastname"];
	$rating = $_POST["review_rating"];
	$review_title = $_POST["review_title"];
	$review_body = $_POST["review_body"];
	$review_category = $_POST["review_category"];
	$referral_category = $_POST["referral_category"];
	$review_url = $_POST["review_url"];
    $review_referral = $_POST["review_referral"];
    $optout = $_POST["optout"];
    
    $fbPost = (isset($_POST['fb_post'])) ? 1 : 0;
    
    
    
    
	$user_id = stripslashes($user_id);
	$user_firstname = stripslashes($user_firstname);
	$user_lastname = stripslashes($user_lastname);
	$rating = stripslashes($rating);
	$review_title = stripslashes($review_title);
	$review_body = stripslashes($review_body); 
    $review_url = stripslashes($review_url); 
	$review_referral = stripslashes($review_referral); 
	 
	$user_id = strip_tags($user_id);
	$user_firstname = strip_tags($user_firstname);
	$user_lastname = strip_tags($user_lastname);
	$rating = strip_tags($rating);
	$review_title = strip_tags($review_title);
	$review_body = strip_tags($review_body);  
    $review_url = strip_tags($review_url); 
    $review_referral = strip_tags($review_referral); 
    
    $review_title = addslashes($review_title);
	$review_body = addslashes($review_body);  
    $review_url = addslashes($review_url); 
	 
	if($review_title == ''){
		$postMessage .= "You need to enter a title for your post<br />";
	} else if($review_body == ''){
		$postMessage .= "You need to fill out the body of your post<br />";
	} else {
	
		$insert = mysql_query("INSERT INTO reviews (user_id, user_firstname, user_lastname, review_rating, review_title, review_body, review_date, review_category, referral_category, review_url, review_referral, optout) 
    VALUES('$user_id','$user_firstname','$user_lastname','$rating','$review_title','$review_body', now() ,'$review_category','$referral_category','$review_url','$review_referral','$optout')") 
	or die (mysql_error());
		
		// post to facebook down here.
		
		if($fbPost)
		{
			$database = database_crud::get_instance();
			
			$token = $database->raw("SELECT `access_token` FROM `myMembers` WHERE `id` = '".$_SESSION['id']."'")->get_obj();
			
			if(isset($token->access_token))
			{
				$data = array(
				
					'access_token' => $token->access_token,
					
					'message'	   => stripslashes($review_body)
				
				);
				
				post2facebook("me/feed", $data);
			}
		}
		
		$postMessage .= "Your Post was sucessful!<br />
				<script type='text/javascript'>
					$(
					$(#'postMessage').show();
					$(#'postMessage').delay(5000).fadeOut('slow');
					);
				</script>";
				
				header("Location: http://word-flow.com/home.php");
	}
	
	if(isset($_FILES["uploaded_file"]["name"]) && !empty($_FILES["uploaded_file"]["name"])) {
		    //Inserting the PHOTO into the DATABASE
		    $sql2 = mysql_query("SELECT * FROM reviews");

		    while($row2 = mysql_fetch_assoc($sql2)){ $review_id = $row2["review_id"];}
		      mkdir("members/$id/uploads", 0777);
		    // Access the $_FILES global variable for this specific file being uploaded
		    // and create local PHP variables from the $_FILES array of information
		    $fileName = $_FILES["uploaded_file"]["name"]; // The file name
		    $fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
		    $fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
		    $fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
		    $fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
		    $kaboom = explode(".", $fileName); // Split file name into an array using the dot
		    $fileExt = end($kaboom); // Now target the last array element to get the file extension
		    // START PHP Image Upload Error Handling --------------------------------------------------
		    if($fileSize > 524288) { // if file size is larger than 5 Megabytes
		        $postMessage .= "Your file was larger than 5 Megabytes in size.<br />";
				
		    } else if (!preg_match("/.(gif|jpg|png|jpeg)$/i", $fileName) ) {
		         // This condition is only if you wish to allow uploading of specific file types    
		         $postMessage .= "Your image was not .gif, .jpg, or .png.<br />";
		         
		    } else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
		        $postMessage .= "An error occured while processing the file. Try again. <br />";

		    }
		    // END PHP Image Upload Error Handling ---------------------------------

		    //CHANGE THE NAME OF THE PHOTO TO MATCH THE REVIEW ID NUMBER
		    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

		    $fileName = $review_id . '.jpg';

		    // Place it into your "uploads" folder mow using the move_uploaded_file() function
		    $moveResult = move_uploaded_file($fileTmpLoc, "members/$id/uploads/$fileName");
		    // Check to make sure the move result is true before continuing
		    if ($moveResult != true) {
		        $postMessage .=  "File not uploaded. Try again. <br />";
		        
		    }

		    // ---------- Include Universal Image Resizing Function --------
		    include_once("include/php_img_lib_1.0.php");
		    $target_file = "members/$id/uploads/$fileName";
		    $resized_file = "members/$id/uploads/resized_$fileName";
		    $wmax = 300;
		    $hmax = 300;
		    ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

		    // ------ Start Universal Image Thumbnail(Crop) Function ------
		    $target_file = "members/$id/uploads/resized_$fileName";
		    $thumbnail = "members/$id/uploads/thumb_$fileName";
		    $wthumb = 150;
		    $hthumb = 150;
		    ak_img_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);
		    // ------- End Adams Universal Image Thumbnail(Crop) Function -------
	}

$postMessage .= '</span>';

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta name="Description" content="Word of Mouth Home Page" />
<meta name="Keywords" content="<?php echo "$firstname, $lastname"; ?> wordofmouth, word, of, mouth, home, page, social, network, reviews" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Word of Mouth | Home</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="scripts/ajaxCompleteRequest.js"></script>
<style type="text/css">

.modal {
	margin: 68px 0px 0px 170px;
	background:white;
	display:block;
	height:85px;
	width:400px;
	position:absolute;
	z-index:9999;
	border:1px solid #CCCCCC;
}
.close-modal {
	text-decoration:none;
	color:#0099FF;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
.close-modal:hover{
	text-decoration:underline;
}
.box {
	color:#0099FF;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;

}
.append {
	display:none;
}
</style>
<script language="javascript" type="text/javascript">
var MYAPP = {};

$(document).ready(function() {
	<?php if ($_GET['filterBy']) { ?>
		$('#filterBy option:selected').val("<?php echo $_GET['filterBy']; ?>");
	<?php } ?>
});
</script>
<script language="javascript" type="text/javascript"> 
$(document).ready(function() {
	$('#boughtItDropDown').click(function() {
		$('#three').hide();
		$('#two').slideToggle();
		$('#one').hide();
		$('.modal').hide();
	});
	$('#referralDropDown').click(function() {
		$('#three').hide();
		$('#two').hide();
		$('#one').slideToggle();
		$('.modal').hide();

	$('.open-modal').click(function () {
		if ($('.modal').style.display="none") {
			$('.modal').show();
		} else {
			$('.modal').hide();
		}
	});
	});

$(function(){   
                // code for fade in element by element with delay
                $.fn.fadeInWithDelay = function(){
                    var delay = 0;
                    return this.each(function(){
                        $(this).delay(delay).animate({opacity:1}, 200);
                        delay += 100;
                    });
                };
                       
            });
}); //END DOM ready

function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
                limitField.value = limitField.value.substring(0, limitNum);
        } else {
                limitCount.value = limitNum - limitField.value.length;
 }
}

//Script to de-pagify the home newsfeed after 5 posts
	MYAPP.flag = false;
	 $(window).scroll(function() {
		if (MYAPP.flag === false) {
			if($(window).scrollTop() == $(document).height() - $(window).height()) {
				MYAPP.flag = true;
				var select = $('#filterBy option:selected').val();
				$("div#text").hide();
				$('div#load_more_posts').show();
					$.ajax( {
						url: "include/load_more_posts.php?lastPost=" + $(".display_newsfeed:last").attr("id") + "&select=" + select,
						success: function(html) {
							if(html) {
								$("#outputDiv").append(html);
								$("#append").append(html);
								$('div#load_more_posts').hide();
								MYAPP.flag = false;
								$("div#text").show();
							} else {
								$('#finished').show();					
								$('#load_more_posts').hide();
							}
						}
				});
			
			}
		}
		
	 });
	 
//This function allows users to paginate if the auto scroll doesn't work
 $(document).ready(function() {
 	$('div#text').click(function(){
 		MYAPP.flag = true;
		var select = $('#filterBy option:selected').val();
				$("div#text").hide();
				$('div#load_more_posts').show();
					$.ajax( {
						url: "include/load_more_posts.php?lastPost=" + $(".display_newsfeed:last").attr("id") + "&select=" + select,
						success: function(html) {
							if(html) {
									$("#outputDiv").append(html);								
									$("#append").append(html);
									$('div#load_more_posts').hide();
									MYAPP.flag = false;
									$("div#text").show();
							} else {
								$('#finished').show();
								$('#load_more_posts').hide();
							}
						}
				});
 	});
	
//This function auto loads the filtering when the select box changes	
	$('#filterBy').change(function () {
		//opted to remove all elements from DOM after bug caused pagination
		//script to stop working.
		$("#append").show();
		$('#append').children().remove();
		$('div.outputDiv').children().remove();
		$('div#finished').hide();					
		$("#text").show();
		var select = $('#filterBy option:selected').val();
		$.ajax ( {
		
			url: "include/filter_by_posts.php?select=" + select,
			success: function(html) {
				if(html) {
					$('#outputDiv').hide();
					$('#filterDiv').hide();
					$('div#load_more_posts').hide();
					$('#append').append(html);
				} else {
					$('#finished').show();
					$('#load_more_posts').hide();
				}
			}
		
		});
	
	});
	
});

</script>
</head>
<body>
<?php include_once 'templates/header_template.php'; ?>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include_once 'templates/sidebar_template.php'; ?>
<div class="wrapOverall">

	

<!-- This is the main column filled with the News Feed -->
       
        <div class="contentLeft">

			<div class="outputHeader">
			
			
			
			<!-- Notifications should go here I think - harrison 
				
				Like Facebook authentication
				
				The feedback link text and so on and so forth...
			
			-->
			
			
			
			
			<h2>Welcome to Word of Mouth, <?php echo "$firstname"; ?>!</h2>
			
			<h3>Check out what your friends are saying!</h2>
			
			</div>
			<div class="outputHeaderRightUnderline">
				<!-- <a href="feedback.php">
					<div class="outputHeaderRight">
						<center><p class="feedbackLink"><br>Here at Word of Mouth we care about what you have to say!<br>Click here to give us feedback about our site!</p></center>
					</div>
				</a> -->
			</div>
			
			<div class="homePost">
			
					<br />
					<div>
						<img src="images/blue_arrow_down.png" height="16px">
						<span class="blue_text" style="font-size:16px;"> Click here to get started!</span>
					</div>
					
					<div class="action-buttons">
						<ul>
							<li class="border"><a href="#" id="boughtItDropDown">Post a New Bought It!</a></li>
							<li class="border"><a href="#" id="referralDropDown">Spread the Word!</a></li>
						</ul>
					</div>
										
					<a href="help.php" class="blue_text" style="font-size:12px;" title="Click Here!">Need Help?</a>
					
			


					<div id="modal1" class="modal" style="display:none;">
    					<div style="margin:10px 0px 0px 10px;">
							<span class="black_text">Posting A link for your friends is optional. If you leave it blank, our team of experts will autofill the link for you. You may choose to optout of this feature in your account settings.</span>

							<a href="#" class="close-modal">Close</a>
						</div>

					</div>
					<!-- ################# REVIEWS ######################## -->

										
					<div id="two" style="background-color:#0099FF; border:1px #DDDDDD solid; display:none; padding:12px; margin-top:1px;">
						<form enctype="multipart/form-data" method="post" action="home.php">
							
							<span class="white_text" style="font-size:14px; color:#FFFFFF;">Title of Product!</span><br />
                			
                			<hr style="color:#0099FF; margin:1px 0px 2px 0px;"/>
                			
                				<textarea type="text" wrap="off" style="overflow-x:hidden;margin:3px 0px 3px 0px; resize: none; " name="review_title" cols="40px" rows="1"></textarea>
                				<div style="float:right;">
                				<span class="white_text" style="margin-right:3px; float:left; font-size:14px; color:#FFFFFF;">Rating:</span>
                				
                				<select name="review_rating" style="margin-right:40px; float:right;">
                					<option value="5">5 (Awesome)</option>
                					<option value="4">4 (Above Average)</option>
                					<option value="3">3 (Decent)</option>
                					<option value="2">2 (Below Average)</option>
                					<option value="1">1 (Turn and Run!)</option>
                				</select>
                				</div>
                				<br />
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">Tell Your Friends About It! (<input readonly type="text" name="countdown" size="3" value="1000" style="border:0px; background-color:#0099FF; color:#FFFFFF;" />)</span><br />
                			
                			<hr style="color:#0099FF; margin:1px 0px 2px 0px;"/>
                			
                				<textarea name="review_body" id="posttext" rows="4" style="margin:0px 0px 5px 0px; resize: none; width:600px;" onKeyDown="limitText(this.form.posttext,this.form.countdown,1000);" onKeyUp="limitText(this.form.posttext,this.form.countdown,1000);"></textarea>

							
                			<br />
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">
                					Add a Website or URL! 

	                				<a href="#modal1" class="open-modal"><img src="images/question_mark.png" width="13px"/></a>
	                				
                			</span>

                			<span class="white_text" style="font-size:14px; color:#FFFFFF; float:right; margin:0px 60px 0px 0px;">Choose A Category:</span><br />
                			
                			<textarea type="text" wrap="off" style="overflow-x:hidden; margin:0px 0px 3px 0px; overflow:hidden ;resize: none; " name="review_url" cols="40px" rows="1" ></textarea>
                			
                			<select name="review_category" style="float:right; margin:0px 60px 0px 0px;">
                				<option value="1">Appliances</option>
                				<option value="2">Apps</option>
                				<option value="3">Automotive</option>
                				<option value="4">Baby</option>
                				<option value="5">Beauty & Make-Up</option>
                				<option value="6">Books & Art</option>
                				<option value="7">Clothing & Accessories</option>
                				<option value="8">Electronics</option>
                				<option value="9">Food</option>
                				<option value="10">Home & Furniture</option>
                				<option value="11">Music</option>
                				<option value="18">Movies</option>
                				<option value="12">Lawn & Garden</option>
                				<option value="13">Pet Supplies</option>
                				<option value="14">Sports & Outdoor</option>
                				<option value="15">Tools/Home Improvement</option>
                				<option value="16">Toys & Games</option>
                				<option value="17">Miscellaneous</option>
                			</select><br />
                			
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">Show It Off With A Picture!<br/> Add a Photo:</span>
							<input style="width:180px;" name="uploaded_file" type="file" />
							
							<div style="float:right;">
								<input style="float:right; margin-right:40px;" type="submit" value="Post!"></input>
							</div>
							<input type="hidden" name="user_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="user_firstname" value="<?php echo $firstname; ?>" />
							<input type="hidden" name="user_lastname" value="<?php echo $lastname; ?>" />
                            <input type="hidden" name="optout" value="<?php echo $optout; ?>" />

							<input type="hidden" name="review_referral" value="0" />
                
                		
                			<br />
						</form>
					</div>
					
					
					<!--///REFERRAL//////////////////////////////////////////////////////////////-->
					<div id="one" style="background-color:#0099FF; border:1px #DDDDDD solid; display:none; padding:12px; margin-top:1px;">
							<form enctype="multipart/form-data" method="post" action="home.php">
							
							<span class="white_text" style="font-size:14px; color:#FFFFFF;">Name of Business or Service:</span><br />
                		
                			<hr style="color:#0099FF; margin:1px 0px 2px 0px;"/>
                			
                				<textarea type="text" wrap="off" style="overflow-x:hidden;margin:3px 0px 3px 0px; resize: none; " name="review_title" cols="40px" rows="1"></textarea>
                				<div style="float:right;">
                				<span class="white_text" style="margin-right:3px; float:left; font-size:14px; color:#FFFFFF;">Rating:</span>
                				
                				<select name="review_rating" style="margin-right:40px; float:right;">
                					<option value="5">5 (Awesome)</option>
                					<option value="4">4 (Above Average)</option>
                					<option value="3">3 (Decent)</option>
                					<option value="2">2 (Below Average)</option>
                					<option value="1">1 (Turn and Run!)</option>
                				</select>
                				</div>
                				<br />
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">Share Your Thoughts with Your Friends! (<input readonly type="text" name="countdown" size="3" value="1000" style="border:0px; background-color:#0099FF; color:#FFFFFF;" />)</span><br />
                			
                			<hr style="color:#0099FF; margin:1px 0px 2px 0px;"/>
                			
                				<textarea name="review_body" id="posttext" rows="4" style="margin:0px 0px 5px 0px; resize: none; width:600px; " onKeyDown="limitText(this.form.posttext,this.form.countdown,1000);" onKeyUp="limitText(this.form.posttext,this.form.countdown,1000);" ></textarea>
                			<br />
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">
                				Add a Website or URL! 
									<a href="#modal1" class="open-modal"><img src="images/question_mark.png" width="13px"/></a>
	                		
	                		</span>
                			<span class="white_text" style="font-size:14px; color:#FFFFFF; float:right; margin:0px 60px 0px 0px;">Choose A Category:</span><br />
                			
                			<textarea type="text" wrap="off" style="overflow-x:hidden; margin:0px 0px 3px 0px; overflow:hidden ;resize: none; " name="review_url" cols="40px" rows="1" ></textarea>
                			
                			<select name="referral_category" style="float:right; margin:0px 60px 0px 0px;">
                				<option value="1">Automotive</option>
                				<option value="2">Business & Professional Services</option>
                				<option value="3">Clothing & Accessories</option>
                				<option value="4">Computers & Electronics</option>
                				<option value="5">Construction & Contractors</option>
                				<option value="6">Education</option>
                				<option value="7">Entertainment</option>
                				<option value="8">Food & Dining</option>
                				<option value="9">Health & Medicine</option>
                				<option value="10">Home & Garden</option>
                				<option value="11">Legal & Financial</option>
                				<option value="12">Media & Communications</option>
                				<option value="19">Online Shopping</option>
                				<option value="13">Personal Care & Services</option>
                				<option value="14">Real Estate</option>
                				<option value="15">Shopping</option>
                				<option value="16">Sports & Recreation</option>
                				<option value="17">Travel & Transportation</option>
                				<option value="18">Miscellaneous</option>

                			</select><br />
                			
                			<span class="white_text" style="font-size:14px; color:#FFFFFF;">Share With A Picture!<br/> Add a Photo:</span>
							<input style="width:180px;" name="uploaded_file" type="file" />
							
							<div style="float:right;">
								<input style="float:right; margin-right:40px;" type="submit" value="Post!"></input>
							</div>
							<input type="hidden" name="user_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="user_firstname" value="<?php echo $firstname; ?>" />
							<input type="hidden" name="user_lastname" value="<?php echo $lastname; ?>" />
                            <input type="hidden" name="optout" value="<?php echo $optout; ?>" />
							<input type="hidden" name="review_referral" value="1" />
                
                		
                			<br />
						</form>
					</div>
			
			</div>
			
			<?php echo $postMessage; ?>
			<hr style="margin:10px 5px 5px 5px;"/>
			
			<div class="newsfeedSubHeader">
				
				<div style="float:right; margin-top:2px;" class="black_text">		
							<form enctype="multipart/form-data" method="post" action="home.php">
							Filter By:
							<select name="filterBy" id="filterBy">
							
							<option value="both" selected="selected">All Reviews and Referrals</option>
							<optgroup label="Reviews">
								<option value="all_reviews">All Reviews</option>
								<option value="1_1">Appliances</option>
                				<option value="1_2">Apps (Android/Iphone)</option>
                				<option value="1_3">Automotive</option>
                				<option value="1_4">Baby</option>
                				<option value="1_5">Beauty & Make-Up</option>
                				<option value="1_6">Books & Art</option>
                				<option value="1_7">Clothing & Accessories</option>
                				<option value="1_8">Electronics</option>
                                <option value="1_9">Food</option>
                				<option value="1_10">Home & Furniture</option>
                				<option value="1_11">Music</option>
                				<option value="1_18">Movies</option>                				
                				<option value="1_12">Lawn & Garden</option>
                				<option value="1_13">Pet Supplies</option>
                				<option value="1_14">Sports & Outdoor</option>
                				<option value="1_15">Tools/Home Improvement</option>
                				<option value="1_16">Toys & Games</option>
                				<option value="1_17">Miscellaneous</option>
                			</optgroup>
                			
                			<optgroup label="Referrals">
								<option value="all_referrals">All Referrals</option>
                				<option value="2_1">Automotive</option>
                				<option value="2_2">Business & Professional Services</option>
                				<option value="2_3">Clothing & Accessories</option>
                				<option value="2_4">Computers & Electronics</option>
                				<option value="2_5">Construction & Contractors</option>
                				<option value="2_6">Education</option>
                				<option value="2_7">Entertainment</option>
                				<option value="2_8">Food & Dining</option>
                				<option value="2_9">Health & Medicine</option>
                				<option value="2_10">Home & Garden</option>
                				<option value="2_11">Legal & Financial</option>
                				<option value="2_12">Media & Communications</option>
                				<option value="2_19">Online Shopping</option>
                				<option value="2_13">Personal Care & Services</option>
                				<option value="2_14">Real Estate</option>
                				<option value="2_15">Shopping</option>
                				<option value="2_16">Sports & Recreation</option>
                				<option value="2_17">Travel & Transportation</option>
                				<option value="2_18">Miscellaneous</option>

							</select>							
							
						</form>
					</div><br /><br />
			
			<hr style="margin:0px 5px 5px 5px;"/>
			</div>

			<div class="append" id="append"></div>
			<div id="outputDiv" class="outputDiv">
<?php
$outputList = '';


//Code for the filter by option ///////////////////////////////////////////////////////////////
if(($_GET['filterBy']) != '') {

	$category_number = $_GET['filterBy'];

	if($_GET['filterBy'] === "both"){
		$where = "";
	} else if($_GET['filterBy'] === "all_reviews"){
		$where = "WHERE `review_referral` = '0'";
	} else if($_GET['filterBy'] === "all_referrals") {
		$where = "WHERE `review_referral` = '1'";
	} else if($_GET['filterBy'] === "1_1"){	
		$where = "WHERE `review_category` = '1'";
	} else if($_GET['filterBy'] === "1_2"){	
		$where = "WHERE `review_category` = '2'";
	} else if($_GET['filterBy'] === "1_3"){	
		$where = "WHERE `review_category` = '3'";
	} else if($_GET['filterBy'] === "1_4"){	
		$where = "WHERE `review_category` = '4'";
	} else if($_GET['filterBy'] === "1_5"){	
		$where = "WHERE `review_category` = '5'";
	} else if($_GET['filterBy'] === "1_6"){	
		$where = "WHERE `review_category` = '6'";
	} else if($_GET['filterBy'] === "1_7"){	
		$where = "WHERE `review_category` = '7'";
	} else if($_GET['filterBy'] === "1_8"){	
		$where = "WHERE `review_category` = '8'";
	} else if($_GET['filterBy'] === "1_9"){	
		$where = "WHERE `review_category` = '9'";
	} else if($_GET['filterBy'] === "1_10"){	
		$where = "WHERE `review_category` = '10'";
	} else if($_GET['filterBy'] === "1_11"){	
		$where = "WHERE `review_category` = '11'";
	} else if($_GET['filterBy'] === "1_12"){	
		$where = "WHERE `review_category` = '12'";
	} else if($_GET['filterBy'] === "1_13"){	
		$where = "WHERE `review_category` = '13'";
	} else if($_GET['filterBy'] === "1_14"){	
		$where = "WHERE `review_category` = '14'";
	} else if($_GET['filterBy'] === "1_15"){	
		$where = "WHERE `review_category` = '15'";
	} else if($_GET['filterBy'] === "1_16"){	
		$where = "WHERE `review_category` = '16'";
    } else if($_GET['filterBy'] === "1_17"){    
        $where = "WHERE `review_category` = '17'";
	} else if($_GET['filterBy'] === "1_18"){	
		$where = "WHERE `review_category` = '18'";
    } else if($_GET['filterBy'] === "2_1"){	
		$where = "WHERE `referral_category` = '1'";
	} else if($_GET['filterBy'] === "2_2"){	
		$where = "WHERE `referral_category` = '2'";
	} else if($_GET['filterBy'] === "2_3"){	
		$where = "WHERE `referral_category` = '3'";
	} else if($_GET['filterBy'] === "2_4"){	
		$where = "WHERE `referral_category` = '4'";
	} else if($_GET['filterBy'] === "2_5"){	
		$where = "WHERE `referral_category` = '5'";
	} else if($_GET['filterBy'] === "2_6"){
		$where = "WHERE `referral_category` = '6'";
	} else if($_GET['filterBy'] === "2_7"){	
		$where = "WHERE `referral_category` = '7'";
	} else if($_GET['filterBy'] === "2_8"){	
		$where = "WHERE `referral_category` = '8'";
	} else if($_GET['filterBy'] === "2_9"){	
		$where = "WHERE `referral_category` = '9'";
	} else if($_GET['filterBy'] === "2_10"){	
		$where = "WHERE `referral_category` = '10'";
	} else if($_GET['filterBy'] === "2_11"){	
		$where = "WHERE `referral_category` = '11'";
	} else if($_GET['filterBy'] === "2_12"){	
		$where = "WHERE `referral_category` = '12'";
	} else if($_GET['filterBy'] === "2_13"){	
		$where = "WHERE `referral_category` = '13'";
	} else if($_GET['filterBy'] === "2_14"){	
		$where = "WHERE `referral_category` = '14'";
	} else if($_GET['filterBy'] === "2_15"){	
		$where = "WHERE `referral_category` = '15'";
	} else if($_GET['filterBy'] === "2_16"){	
		$where = "WHERE `referral_category` = '16'";
	} else if($_GET['filterBy'] === "2_17"){	
		$where = "WHERE `referral_category` = '17'";
	} else if($_GET['filterBy'] === "2_18"){	
		$where = "WHERE `referral_category` = '18'";
	} else if($_GET['filterBy'] === "2_19"){	
		$where = "WHERE `referral_category` = '19'";
	}
	
	
}

		$review_query = mysql_query("SELECT * FROM `reviews` $where ORDER BY `review_id` DESC LIMIT 0, 5");
		$review_num_rows = mysql_num_rows($review_query);
		
		if($review_num_rows == 0) {
			echo "<div class='black_text' id='no_review' style='font-size:24px; margin:30px 0px 0px 0px;'><center>Oops, No Reviews have been Written Yet!</center></div>";
		}
		while($review_row = mysql_fetch_assoc($review_query)){
    		
    		$review_title = $review_row['review_title'];
    		
    		$user_id = $review_row['user_id'];	
    		$user_firstname = $review_row['user_firstname'];
    		$user_lastname = $review_row['user_lastname'];
    		$review_id = $review_row['review_id'];
    		$review_body = $review_row['review_body'];
    		$review_referral = $review_row['review_referral'];
    	
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
    	
    			$review_date = $review_row['review_date'];
    				$review_date = date_create($review_date);
    				$review_date = date_format($review_date, 'F jS\, Y');
    			$user_firstname = $review_row['user_firstname'];
    			$review_rating = $review_row['review_rating'];
    	
    		
    		///////  Display Picture. See if they have uploaded a pic or not  //////////////////////////
			$check_pic = "members/$user_id/thumb_image01.jpg";
			$default_pic = "members/0/image01.jpg";
				if (file_exists($check_pic)) {
   					$review_pic = "<img src=\"$check_pic\" width=\"80px\" />"; 
				} else {
					$review_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
				}
				
			
				
    		//Pull the number of stars to be displayed
			include('include/star_display.php');			

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
        
			//while (in_array($user_id, $friend_array) == true) {
		
			//CODE TO DISTINGUISH REFERRALS FROM REVIEWS			
			//Final Output List
			if($review_referral == 0) {
					//Code for Displaying URL Link
					$review_url = remove_http($review_url);
   					$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
    				
    					echo '
    					<div class="display_newsfeed" id="'.$review_id.'">
                  			<table id="'.$review_id.'" style="width:98.5%; border:#00B347 1px solid; margin:10px 0px 20px 10px;">
                  			<td style="float:left; width:15%; border-right:1px solid #DDDDDD; margin:5px 0px 5px 0px;">
                  								<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
												<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
                  								<div class="bought_it_newsfeed">Bought It!</div>
                  					</td>
                  					<td style="float:right; width:82%;">
                  							<div class="review_title_p">
                  								<p><span class="review_title"><a href="post_content.php?id='. $review_id .'">'. $review_title .'</a></span><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
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
    						<div class="display_newsfeed" id="'.$review_id.'">
                  			<table id="'.$review_id.'" style="width:98.5%; border:#0099FF 1px solid; margin:10px 0px 20px 10px;">
                  			<td style="float:left; width:15%; border-right:1px solid #DDDDDD; margin:5px 0px 5px 0px;">
                  								<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
												<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
                  								<div class="referral_newsfeed">Referral</div>
                  					</td>
                  					<td style="float:right; width:82%;">
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
				  }
		//	}	  			
		} ?>
			</div> <!-- END outputDiv -->
		
			<div class="box" id="box">
				<div class="text" id="text">
					<center>Click to Show More Posts</center>
				</div>
				<div class="finished" id='finished' style="display:none">
					<center>Finished loading all Posts!</center>
				</div>
				<div id='load_more_posts' style="display:none">
						<center>
							<img src="images/loading.gif" alt="Loading" />
						</center>
				</div>
			</div>
	       
        </div> <!-- END contentleft -->        
        
        

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
        				
        						<a href="inbox.php">
        					
        							Inbox
        					
        							<?php echo " (".$messageAlert.")" ;?>
        							
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
		<?php echo $friendList ?>
		</div>

		<!-- Social Integration here (Such as facebook sharing, following on Twitter, etc.)-->
		<hr style="margin-left:5px; margin-right:5px;"/>
		<div class="social">
			

			<!-- Facebook -->
  			
  			<div class="black-text" style="font-size:14px; margin-left:5px;">
				<strong>Share on Facebook <!-- for 100 Points! --><br/></strong>
			</div>

		    <div id='fb-root'></div>
		    <script src='http://connect.facebook.net/en_US/all.js'></script>
		    <p>
		    	<a onclick='postToFeed(); return false;'>
		    		<div style="margin-left:5px;">
		    			<!-- Here we need the addPoints.php to be run and the 100 points to be added and the enum changed to 0 (AJAX maybe?) -->
								<img src="images/facebook.jpg"/>
						</form>
					</div>
				</a>
			</p>
		    <p id='msg'></p>

		    <script> 
		      FB.init({appId: "392202854140688", status: true, cookie: true});

		      function postToFeed() {

		        // calling the API ...
		        var obj = {
		          method: 'feed',
		          redirect_uri: 'http://www.word-flow.com/home.php',
		          link: 'http://word-flow.com/welcome.php',
		          picture: 'http://word-flow.com/images/WordofMouth.jpg',
		          name: 'Word of Mouth Social Network',
		          caption: 'Join Today to Start Reviewing!',
		          description: 'Word of Mouth makes reviews more personal than ever by showing what your friends think about products. You also get paid to review so head over and start today!'
		        };

		        function callback(response) {
		          document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
		        }

		        FB.ui(obj, callback);
		      }
		    
		    </script>
		    <hr style="margin-left:5px; margin-right:5px;"/>

		    <!-- Twitter -->
			<div class="black-text" style="font-size:14px; margin-left:5px;">
			<strong>Follow Us on Twitter <!-- for 100 Points!--><br/><br/></strong>
			</div>
			<div style="margin-left:5px;">
					<a href="https://twitter.com/itswordofmouth" class="twitter-follow-button" data-show-count="false" data-size="large">
					<!-- Here we need the addPoints.php to be run and the 100 points to be added and the enum changed to 0 (AJAX maybe?) -->
					Follow @itswordofmouth
					</a>
			</div>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



			<hr style="margin-left:5px; margin-right:5px;"/>

		    <!-- Like us on Facebook --> 
		    <div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=392202854140688";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-like" data-href="http://www.facebook.com/pages/Word-of-Mouth/426733887366134" data-send="false" data-width="200" data-show-faces="true" data-font="lucida grande" style="margin-left:5px;"></div>


			<!-- StumbleUpon -->
			<!-- Place this tag where you want the su badge to render -->

			<hr style="margin-left:5px; margin-right:5px;"/>

			<strong>Share Us on Stumbleupon<br/><br/></strong>
			<su:badge layout="1"></su:badge>

			<!-- Place this snippet wherever appropriate -->
			<script type="text/javascript">
			  (function() {
			    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
			    li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
			  })();
			</script>

			
		</div><!-- END of social -->
		


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
				<a href="https://bestbuy.com/" target="_BLANK">Best Buy</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
				<a href="http://www.buy.com/" target="_BLANK">buy.com</a><br /><hr style="margin-left:5px; margin-right:5px;"/>
			</div>

		</div>
		

		

		<!-- This is the Advertisements code
		<hr style="margin-left:5px; margin-right:5px;"/>
		<div class="advertisements_box" style="font-size:18px; margin-left:5px;">
	    Advertisements:<br /><br />
		
		<img src="" width="270px" /> <br /><br /><br /><br /><br />
		
		</div> -->
		


		<!-- START FOOTER -->
		<div id="footer" style="margin-left:5px;">
			        	<span class="subtext">
                               <a href="about_us.php">About Us</a> 
                             | <a href="privacy_policy.php">Privacy Policy</a> 
                             | <a href="terms_of_service.php">Terms of Use</a>
                             | <a href="contact_us.php">Contact Us</a>
                             | <a href="help.php">Help</a>
                             | Word of Mouth &copy; 2012
                        </span>
        </div> <!-- END FOOTER -->
	</div> <!-- END contentRight -->
	
<!-- FOOTER -->
	<div class="footer">
	<?php include_once 'templates/footer_template.php'; ?>
	</div>

</div> <!-- END wrapOverall -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="scripts/modal.js"></script>
		<script type="text/javascript">

			(function($){

				// basic way of doing it. uses default settings defined in plugin

				$('.modal').modalWindow();

			}(jQuery));

		</script>
</body>
</html>