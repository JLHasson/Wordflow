<?php 
$review_rating = 5;
if($review_rating == 5) {

	$review_stars = '<img src="star_5.png" name="5_stars" />';

} else if($review_rating == 4) {

	$review_stars = '<img src="star_4.png" name="4_stars" />';

} else if($review_rating == 3) {

	$review_stars = '<img src="star_3.png" name="3_stars" />';

} else if($review_rating == 2) {

	$review_stars = '<img src="star_2.png" name="2_stars" />';

} else if($review_rating == 1) {

	$review_stars = '<img src="star_1.png" name="1_stars" />';

}
echo $review_stars;

?>