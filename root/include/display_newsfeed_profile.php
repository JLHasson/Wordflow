<?php 	

$outputList = '';
$review_query = mysql_query("SELECT * FROM `reviews` WHERE user_id='$id' ORDER BY `review_date` DESC LIMIT 4");

while($review_row = mysql_fetch_assoc($review_query)){
    					
    	$review_title = $review_row['review_title'];
    	$user_id = $review_row['user_id'];
    	$user_firstname = $review_row['user_firstname'];
    	$user_lastname = $review_row['user_lastname'];
    	$review_id = $review_row['review_id'];
    	$review_body = $review_row['review_body'];
    		
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
    	$review_rating = $review_row['rating'];
    	
    	
    	
    	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
		$check_pic = "members/$user_id/thumb_image01.jpg";
		$default_pic = "members/0/image01.jpg";
			if (file_exists($check_pic)) {
    			$review_pic = "<img src=\"$check_pic\" width=\"60px\" />"; 
			} else {
				$review_pic = "<img src=\"$default_pic\" width=\"60px\" />"; 
			}
    	
    		
 
 
 
    	//Star Display Code
		if($review_rating == 5) {

			$review_stars = '<img src="images/stars/star_5.png" width="80px" name="5_stars" />';

		} else if($review_rating == 4) {

			$review_stars = '<img src="images/stars/star_4.png" width="80px" name="4_stars" />';

		} else if($review_rating == 3) {

			$review_stars = '<img src="images/stars/star_3.png" width="80px" name="3_stars" />';

		} else if($review_rating == 2) {

			$review_stars = '<img src="images/stars/star_2.png" width="80px" name="2_stars" />';

		} else if($review_rating == 1) {
	
			$review_stars = '<img src="images/stars/star_1.png" width="80px" name="1_stars" />';

		}			




		//Pull the Category from the row
		$review_category = $review_row['review_category'];

		// REVIEW CATEGORY NUMBERS EXPLAINED
		// 1 - Appliances
		// 2 - Apps (Android/Apple)
		// 3 - Automotive
		// 4 - Baby 
		// 5 - Beauty and Make-Up
		// 6 - Books/Art
		// 7 - Clothing and Accessories 
		// 8 - Electronics  
		// 9 - Home and Furniture
		// 10 - Music 
		// 11 - Lawn and Garden
		// 12 - Pet Supplies
		// 13 - Sports and Outdoor
		// 14 - Tools and Home Improvement
		// 15 - Toys and Games
		// 16 - Misc

		//Decide which icon will be displayed in the category
		if($review_category == 1) {

			$review_category = '<a name="review_category_appliances" href="#">Appliances</a>';

		} else if($review_category == 2) {

			$review_category = '<a name="review_category_apps" href="#">Apps</a>';

		} else if($review_category == 3) {

			$review_category = '<a name="review_category_automotive" href="#">Automotive</a>';

		} else if($review_category == 4) {

			$review_category = '<a name="review_category_baby" href="#">Baby</a>';

		} else if($review_category == 5) {

			$review_category = '<a name="review_category_beauty" href="#">Beauty</a>';

		} else if($review_category == 6) {

			$review_category = '<a name="review_category_books" href="#">Books</a>';

		} else if($review_category == 7) {

			$review_category = '<a name="review_category_clothing" href="#">Clothing & Accessories</a>';

		} else if($review_category == 8) {

			$review_category = '<a name="review_category_electronics" href="#">Electronics</a>';

		} else if($review_category == 9) {

			$review_category = '<a name="review_category_home" href="#">Home & Furniture</a>';

		} else if($review_category == 10) {

			$review_category = '<a name="review_category_music" href="#">Music</a>';

		} else if($review_category == 11) {

			$review_category = '<a name="review_category_lawn" href="#">Lawn & Garden</a>';

		} else if($review_category == 12) {

			$review_category = '<a name="review_category_pet" href="#">Pet Supplies</a>';

		} else if($review_category == 13) {

			$review_category = '<a name="review_category_sports" href="#">Sports & Outdoor</a>';

		} else if($review_category == 14) {

			$review_category = '<a name="review_category_tools" href="#">Tools & Home Improvement</a>';

		} else if($review_category == 15) {

			$review_category = '<a name="review_category_toys" href="#">Toys & Games</a>';

		} else if($review_category == 16) {
		
			$review_category = '<a name="review_category_misc" href="#">Miscellaneous</a>';

		} else {
			//If the review category does not equal any of these (which it should never do) display an error.
			$review_category = '<img src="images/error.png" name="category_error" />';
		}

		
		//Code for URL for Each Review
		$review_url = $review_row['review_url'];
		if (!function_exists('remove_http')) {
	    	function remove_http($url = '') {
				return(str_replace(array('http://','https://'), '', $url));
			}
		}
        $review_url = remove_http($review_url);
   		$review_url = "<a target='_BLANK' href='http://". $review_url ."'>Buy It Here!</a> ";
					
		
		
		
		//Final Output List
    					$outputList .= '
    				
                  			<table id="'.$review_id.'" style="width:100%;">
                  					<td style="float:left; width:15%;">
												<div class="review_prof_pic"><a href="profile.php?id='. $user_id .'">'. $review_pic .'</a></div>
                  								<div class="review_user_name"><a href="profile.php?id='. $user_id .'">'. $user_firstname.' '. $user_lastname .'</a></div>
                  							
                  					</td>
                  					<td style="float:right; width:83%;">
                  							<div class="review_title_p">
                  								<p><a href="post_content.php?id='. $review_id .'">'. $review_title .'</a><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
                  							</div>
                  							<div class="review_read_more">
                  								<p class="review_body_p">'. $review_body .'</p>
                  								<div>
                  									<div style="float:left;" class="review_black_font_link">Website:'. $review_url .'</div>
                  									<div style="float:right; margin-right:20px;" class="review_black_font_link">Category:'. $review_category .'</div>
                  								</div>
                  							</div>
                  					</td>
                  					
                  			</table>
				  			<hr style="margin:0px 20px 0px 20px;" /> 	
				  			
				  						';
				  			
} 
?>