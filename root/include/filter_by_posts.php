<?php

// Connecting to the Mysql Database
// Hostname
$db_host = "";
// Username
$db_username = ""; 
// Password
$db_pass = ""; // nothing1035357 // mike its not working because someone changed my password
// Name of Database
$db_name = "";

// Run the connection here 
mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to the database -- Connect to mysql page .php");
mysql_select_db("$db_name") or die ("no database");



$where = '';
//Code for the filter by option ///////////////////////////////////////////////////////////////
	
	if($_GET['select'] === "both"){
		$where = "";
	} else if($_GET['select'] === "all_reviews"){
		$where = "WHERE `review_referral` = '0'";
	} else if($_GET['select'] === "all_referrals") {
		$where = "WHERE `review_referral` = '1'";
	} else if($_GET['select'] === "1_1"){	
		$where = "WHERE `review_category` = '1'";
	} else if($_GET['select'] === "1_2"){	
		$where = "WHERE `review_category` = '2'";
	} else if($_GET['select'] === "1_3"){	
		$where = "WHERE `review_category` = '3'";
	} else if($_GET['select'] === "1_4") {
		$where = "WHERE `review_category` = '4'";
	} else if($_GET['select'] === "1_5"){	
		$where = "WHERE `review_category` = '5'";		
	} else if($_GET['select'] === "1_6"){	
		$where = "WHERE `review_category` = '6'";		
	} else if($_GET['select'] === "1_7"){	
		$where = "WHERE `review_category` = '7'";		
	} else if($_GET['select'] === "1_8"){	
		$where = "WHERE `review_category` = '8'";		
	} else if($_GET['select'] === "1_9"){	
		$where = "WHERE `review_category` = '9'";		
	} else if($_GET['select'] === "1_10"){	
		$where = "WHERE `review_category` = '10'";		
	} else if($_GET['select'] === "1_11"){	
		$where = "WHERE `review_category` = '11'";		
	} else if($_GET['select'] === "1_12"){	
		$where = "WHERE `review_category` = '12'";		
	} else if($_GET['select'] === "1_13"){	
		$where = "WHERE `review_category` = '13'";		
	} else if($_GET['select'] === "1_14"){	
		$where = "WHERE `review_category` = '14'";		
	} else if($_GET['select'] === "1_15"){	
		$where = "WHERE `review_category` = '15'";		
	} else if($_GET['select'] === "1_16"){	
		$where = "WHERE `review_category` = '16'";		
	} else if($_GET['select'] === "1_17"){	
		$where = "WHERE `review_category` = '17'";		
	} else if($_GET['select'] === "1_18"){	
		$where = "WHERE `review_category` = '18'";		
	} else if($_GET['select'] === "2_1"){	
		$where = "WHERE `referral_category` = '1'";
	} else if($_GET['select'] === "2_2"){	
		$where = "WHERE `referral_category` = '2'";
	} else if($_GET['select'] === "2_3"){	
		$where = "WHERE `referral_category` = '3'";
	} else if($_GET['select'] === "2_4"){	
		$where = "WHERE `referral_category` = '4'";
	} else if($_GET['select'] === "2_5"){	
		$where = "WHERE `referral_category` = '5'";
	} else if($_GET['select'] === "2_6"){
		$where = "WHERE `referral_category` = '6'";
	} else if($_GET['select'] === "2_7"){	
		$where = "WHERE `referral_category` = '7'";
	} else if($_GET['select'] === "2_8"){	
		$where = "WHERE `referral_category` = '8'";
	} else if($_GET['select'] === "2_9"){	
		$where = "WHERE `referral_category` = '9'";
	} else if($_GET['select'] === "2_10"){	
		$where = "WHERE `referral_category` = '10'";
	} else if($_GET['select'] === "2_11"){	
		$where = "WHERE `referral_category` = '11'";
	} else if($_GET['select'] === "2_12"){	
		$where = "WHERE `referral_category` = '12'";
	} else if($_GET['select'] === "2_13"){	
		$where = "WHERE `referral_category` = '13'";
	} else if($_GET['select'] === "2_14"){	
		$where = "WHERE `referral_category` = '14'";
	} else if($_GET['select'] === "2_15"){	
		$where = "WHERE `referral_category` = '15'";
	} else if($_GET['select'] === "2_16"){	
		$where = "WHERE `referral_category` = '16'";
	} else if($_GET['select'] === "2_17"){	
		$where = "WHERE `referral_category` = '17'";
	} else if($_GET['select'] === "2_18"){	
		$where = "WHERE `referral_category` = '18'";
	} else if($_GET['select'] === "2_19"){	
		$where = "WHERE `referral_category` = '19'";
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
    				$review_date = date_format($review_date, 'g:ia \o\n F jS\, Y');
    			$user_firstname = $review_row['user_firstname'];
    			$review_rating = $review_row['review_rating'];
    	
			
    	
    		///////  Display Picture. See if they have uploaded a pic or not  //////////////////////////
			$check_pic = "../members/$user_id/thumb_image01.jpg";
			$default_pic = "members/0/image01.jpg";
				if (file_exists($check_pic)) {
   					$review_pic = "<img src=\"http://word-flow.com/members/".$user_id."/thumb_image01.jpg\" width=\"80px\" />"; 
				} else {
					$review_pic = "<img src=\"$default_pic\" width=\"80px\" />"; 
				}
			
			
    		//Pull the number of stars to be displayed
			include('star_display.php');			

			//Pull the Review Category from the row
			$review_category = "";
			$review_category = $review_row['review_category'];
			include('review_category.php');

		
			//Pull the Referral Category from the row
			$referral_category = "";
			$referral_category = $review_row['referral_category'];
			include('referral_category.php');

		
			//Code for URL for Each Review
			$review_url = $review_row['review_url'];
			if (!function_exists('remove_http')) {
	    		function remove_http($url = '') {
					return(str_replace(array('http://','https://'), '', $url));
				}
			}
        
		
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
                  								<p><span class="review_title"><a href="post_content.php?id='.$review_id.'">'. $review_title .'</a></span><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
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
				  			
		}


?>