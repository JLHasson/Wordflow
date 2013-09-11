<?php
 include_once "mysql_server/checkuserlog.php";
 include "include/search_function.php";
 
 	$outputList = "";
 	$outputListFriend = "";
 	$outputSearch = "";
 	$outputTitle = "";
 	$suffix = "";
 	$errorDisplay = "";
 	$outputTitle = "Please enter a search term above";
 	

$id = $_SESSION['id'];

$sql = mysql_query("SELECT * FROM myMembers WHERE id='$id' LIMIT 1");

// ------- START WHILE LOOP FOR GETTING THE MEMBER DATA ---------
while($row = mysql_fetch_array($sql)){ 
	extract($row);
	$friend_array = $row['friend_array'];
   
}		
	$friendArray = explode(",", $friend_array);


 if (isset($_POST['search_for'])) {

 	$search_for = mysql_real_escape_string(htmlspecialchars(trim($_POST['search_for'])));
	
 	$errors = array();
 	
 	if (empty($search_for)) {
 		$errors[] = "";
 		
 	} else if (strlen($search_for) < 4) {
 		$errors[] = "Your search term must be more than 3 characters";
 	} else if (search_results($search_for) === false) {
 		$errors[] = "Your search for ".$search_for." returned no posts!";
 		$outputTitle = "Uh-oh! Please try a new search!";
 	}
 	
 	if (empty($errors)) {
 		$results = search_results($search_for);
 		$results_num = count($results);
 		
 		$suffix = ($results_num != 1) ? 's' : '';
 		
 		//Display Search Results
 		foreach($results as $result){
 		
 			$review_title = $result['review_title'];
    		$user_id = $result['user_id'];
    		$user_firstname = $result['user_firstname'];
    		$user_lastname = $result['user_lastname'];
    		$review_id = $result['review_id'];
    		$review_body = $result['review_body'];
    		$review_referral = $result['review_referral'];
    	
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
    	
    		$review_date = $result['review_date'];
    		$review_date = date_create($review_date);
    		$review_date = date_format($review_date, 'F jS\, Y');
    		$user_firstname = $result['user_firstname'];
    		$review_rating = $result['rating'];
    	
    	
    	
    		///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
			$check_pic = "members/$user_id/thumb_image01.jpg";
			$default_pic = "members/0/image01.jpg";
				if (file_exists($check_pic)) {
    				$review_pic = "<img src=\"$check_pic\" width=\"80px\" />"; 
				} else {
					$review_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
				}
    	
    		
    		include_once('include/star_display.php');			




		//Pull the Review Category from the row
		$review_category = $result['review_category'];
		include_once('include/review_category.php');

		
		//Pull the Referral Category from the row
		$referral_category = $result['referral_category'];
		include_once('include/referral_category.php');

		
		//Code for URL for Each Review
		$review_url = $result['review_url'];
		if (!function_exists('remove_http')) {
	    	function remove_http($url = '') {
				return(str_replace(array('http://','https://'), '', $url));
			}
		}
       //Final Output List
       if(in_array($user_id, $friendArray)){
			if($review_referral == 0) {
					//Code for Displaying URL Link
					$review_url = remove_http($review_url);
   					$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
    				
    				$outputListFriend .= '
    					<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
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
				  		
			  		$outputListFriend .= '
    						<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
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
                  									<div style="float:right; margin-right:20px;" class="review_black_font_link">Category: '.$referral_category_post .'</div>
                  								</div>
                  							</div>
                  					</td>
                  					
                  			</table>
				  			<hr style="margin:0px 20px 0px 20px;" /> 	
				  			</div>
				  						';
				  }
				  				
		}else {
					 
					 if($review_referral == 0) {
					//Code for Displaying URL Link
					$review_url = remove_http($review_url);
   					$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
    				
    				$outputList .= '
    					<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
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
				  		
			  		$outputList .= '
    						<div class="display_newsfeed" id="'.$review_id.' display_newsfeed">
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
                  									<div style="float:right; margin-right:20px;" class="review_black_font_link">Category: '.$referral_category_post .'</div>
                  								</div>
                  							</div>
                  					</td>
                  					
                  			</table>
				  			<hr style="margin:0px 20px 0px 20px;" /> 	
				  			</div>
				  						';
				  }
					  
		}
 			$outputTitle = "Your Search for ".$search_for." returned ".$results_num." result".$suffix.":";
 
 	}
 		
 		
 	} else {
 		foreach($errors as $error) {
 			$errorDisplay = "".$error." <br />";
 		}
 	}
 
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content=text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Search Page" />
<meta name="Keywords" content="word, of, mouth, search, page" />
<meta name="rating" content="General" />
<title>Word of Mouth | Search</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> <!-- AND HERE -->
</head>
<body>

<?php include_once 'templates/header_template.php'; ?>
	
    <div class="wrapOverall">
	
        <div class="contentMain" align="left" cellpadding="8" cellspacing="0">
	        <div style="height:30px;">
	        	<div><p class="black_text" style="font-size:20px;"><?php echo $outputTitle;?></p></div>
	        </div>
	        <div>
	        	<div>
	        		<div class="friendResultsHeader">Friends Results:</div>
	        		<?php echo $outputListFriend; ?>
	        		<?php echo $errorDisplay; ?>
	        	</div>
	        </div>
	        <br />
	        
	        <div>
	        	<div>
	        		<div class="everyoneResultsHeader">Everyone's Results:</div>
	        		<?php echo $outputList; ?>
	        		<?php echo $errorDisplay; ?>
	        	</div>
	        </div>
        </div>

		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>