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
              
        Total Points Earned: <?php print "$pointSystem"; ?><br/>
        Points left to Spend: <?php print "$pointActive"; ?><br/>

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
<!-- This is the Advertisements code -->
		
		<div class="advertisements_box" style="font-size:18px; margin-left:5px;">
		Advertisements: <br /><br />
		
		<img src="" width="270px" /> <br /><br /><br /><br /><br />
		
		</div>
		
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