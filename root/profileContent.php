<?php
include_once ("mysql_server/checkuserlog.php");
$getId = $_GET['id'];
$review_query = mysql_query("SELECT * FROM `reviews` WHERE user_id='$getId' ORDER BY `review_date` DESC LIMIT 0, 5");
 $sql = mysql_query("SELECT * FROM myMembers WHERE id='". $_GET['id'] ."' LIMIT 1");
 while ($row = mysql_fetch_assoc($sql)) {
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $fullname = $firstname . ' ' . $lastname;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf8_general_ci" />
<meta name="Description" content="Word Of Mouth Template Page" />
<meta name="Keywords" content="fill, in, information" />
<meta name="rating" content="General" />
<title><?php echo $fullname .'\'s posts'?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="#" type="image/x-icon" /> <!-- INSERT ICON -->
<link rel="shortcut icon" href="#" type="image/x-icon" /> <!-- AND HERE -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
var MYAPP = {};
  MYAPP.profileFlag = false;
   $(window).scroll(function() {
    if (MYAPP.profileFlag === false) {
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
        MYAPP.profileFlag = true;
        $('div#load_more_posts').show();
          $.ajax( {
            url: "../include/load_more_profile.php?lastPost=" + $(".display_newsfeed:last").attr("id") + "&profile=" + <?php echo $_GET['id'];?>,
            success: function(html) {
              if(html) {
                $(".outputDiv").append(html);
                $('div#load_more_posts').hide();
                MYAPP.profileFlag = false;
              } else {
                $('div#load_more_posts').replaceWith("<center>Finished loading all Posts!</center>");
              }
            }
        });
      
    }
    }
    
   });
</script>
</head>
<body>
	
	<?php include_once 'templates/header_template.php'; ?>

    <div class="wrapOverall">

        <div class="contentMain" height="1000px" align="left" cellpadding="8" cellspacing="0" style="background-color:#FBFBFB;" align="center">    
          <div class="outputDiv" align="center">

<?php 
		$review_num_rows = mysql_num_rows($review_query);
		
		if($review_num_rows == 0) {
			echo "<div class='black_text' style='font-size:24px; margin:30px 0px 0px 0px;'><center>Oops, no Reviews have been Written Yet!</center></div>";
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
    			$review_rating = $review_row['rating'];
    	
    	
    	
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
                  								<p><a href="post_content.php?id='. $review_id .'">'. $review_title .'</a><span class="review_date_p">'. $review_date .'</span><span class="review_stars">'. $review_stars .'</span></p>
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
				  }	}?>	
		</div>
  </div>
    <div id='load_more_posts' style="display:none">
        <center>
          <img src="../../images/loading.gif" alt="Loading" />
        </center>
    </div>

		
		<?php include_once 'templates/footer_template.php'; ?>


	</div> <!-- END wrapOverall -->

</body>
</html>