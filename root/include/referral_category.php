<?php
$referral_category_post = '';
		// REFERRAL CATEGORY NUMBERS EXPLAINED
		// 1 - Automotive
		// 2 - Business & Professional Services
		// 3 - Clothing & Accessories
		// 4 - Computers & Electronics
		// 5 - Construction & Contractors
		// 6 - Education
		// 7 - Entertainment
		// 8 - Food & Dining
		// 9 - Health & Medicine
		// 10 - Home & Garden
		// 11 - Legal & Financial
		// 12 - Media & Communications
		// 13 - Personal Care & Services
		// 14 - Real Estate
		// 15 - Shopping
		// 16 - Sports & Recreation
		// 17 - Travel & Transportation
		// 18 - Misc

		//Decide which icon will be displayed in the category
		if($referral_category == 1) {

			$referral_category_post .= 'Automotive';

		} else if($referral_category == 2) {

			$referral_category_post .= 'Business & Professional Services';

		} else if($referral_category == 3) {

			$referral_category_post .= 'Clothing & Accessories';

		} else if($referral_category == 4) {

			$referral_category_post .= 'Computers & Electronics';

		} else if($referral_category == 5) {

			$referral_category_post .= 'Construction & Contractors';

		} else if($referral_category == 6) {

			$referral_category_post .= 'Education';

		} else if($referral_category == 7) {

			$referral_category_post .= 'Entertainment';

		} else if($referral_category == 8) {

			$referral_category_post .= 'Food & Dining';

		} else if($referral_category == 9) {

			$referral_category_post .= 'Health & Medicine';

		} else if($referral_category == 10) {

			$referral_category_post .= 'Home & Garden';

		} else if($referral_category == 11) {

			$referral_category_post .= 'Legal & Financial';

		} else if($referral_category == 12) {

			$referral_category_post .= 'Media & Communications';

		} else if($referral_category == 13) {

			$referral_category_post .= 'Personal Care & Services';

		} else if($referral_category == 14) {

			$referral_category_post .= 'Real Estate';

		} else if($referral_category == 15) {

			$referral_category_post .= 'Shopping';

		} else if($referral_category == 16) {
		
			$referral_category_post .= 'Sports & Recreation';

		} else if($referral_category == 17) {
		
			$referral_category_post .= 'Travel & Transportation';
 
		} else if($referral_category == 18) {
		
			$referral_category_post .= 'Miscellaneous';
		
		} else if($referral_category == 19) {

			$referral_category_post .= 'Online Shopping';

		} else {
			//If the review category does not equal any of these.
			$referral_category_post .= '';
		}
		
?>