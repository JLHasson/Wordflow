<?php
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



/*

// use this to replace the whole if - else statement above. Much simpler.

function get_stars($rating)
{
	// we need to find a better way to do this. this is pretty inefficient.
	
	if($rating > 5 || $rating == 0) {} else {
		return '<img src="images/stars/star_"'.$rating.'.png" width="80px" name="'.$rating.'_stars"';
	}
}
*/




?>