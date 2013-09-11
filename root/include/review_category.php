<?php
$review_category_post = '';
		// REVIEW CATEGORY NUMBERS EXPLAINED
		// 1 - Appliances
		// 2 - Apps (Android/Apple)
		// 3 - Automotive
		// 4 - Baby 
		// 5 - Beauty and Make-Up
		// 6 - Books/Art
		// 7 - Clothing and Accessories 
		// 8 - Electronics  
		// 9 - Food
		// 10 - Home and Furniture
		// 11 - Music 
		// 12 - Lawn and Garden
		// 13 - Pet Supplies
		// 14 - Sports and Outdoor
		// 15 - Tools and Home Improvement
		// 16 - Toys and Games
		// 17 - Misc

		//Decide which icon will be displayed in the category
		if($review_category == 1) {

			$review_category_post .= 'Appliances';

		} else if($review_category == 2) {

			$review_category_post .= 'Apps';

		} else if($review_category == 3) {

			$review_category_post .= 'Automotive';

		} else if($review_category == 4) {

			$review_category_post .= 'Baby';

		} else if($review_category == 5) {

			$review_category_post .= 'Beauty';

		} else if($review_category == 6) {

			$review_category_post .= 'Books & Art';

		} else if($review_category == 7) {

			$review_category_post .= 'Clothing & Accessories';

		} else if($review_category == 8) {

			$review_category_post .= 'Electronics';

		} else if($review_category == 9) {

			$review_category_post .= 'Food';

		} else if($review_category == 10) {

			$review_category_post .= 'Home & Furniture';

		} else if($review_category == 11) {

			$review_category_post .= 'Music';

		} else if($review_category == 12) {

			$review_category_post .= 'Lawn & Garden';

		} else if($review_category == 13) {

			$review_category_post .= 'Pet Supplies';

		} else if($review_category == 14) {

			$review_category_post .= 'Sports & Outdoor';

		} else if($review_category == 15) {

			$review_category_post .= 'Tools & Home Improvement';

		} else if($review_category == 16) {

			$review_category_post .= 'Toys & Games';

		} else if($review_category == 17) {
		
			$review_category_post .= 'Miscellaneous';

		} else if($review_category == 18) {
		
			$review_category_post .= 'Movies';

		} else {
			//If the review category does not equal any of these.
			$review_category_post = '';
		}


// harrison's way of doing it.


/*
$review_category_post = '';

function get_review($number)
{
	$reviews = array(
	'',
	'Appliances',
	'Apps',
	'Automotive',
	'Baby',
	'Beauty',
	'Books & Art',
	'Clothing & Accessories',
	'Electronics',
	'Food',
	'Home & Furniture',
	'Music',
	'Lawn & Garden',
	'Pet Supplies',
	'Sports & Outdoor',
	'Tools & Home Improvement',
	'Toys & Games',
	'Miscellaneous',
	'Movies',

	);
	
	return ($number > count($reviews)) ? '' : $reviews[$number];
}

$review_category_post = get_review($review_category)
		
*/
?>