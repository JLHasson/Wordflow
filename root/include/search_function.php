<?php

function search_results($search_for) {
	$returned_results = array();
	$where = "";

	$search_for = preg_split('/[\s]+/', $search_for);
	$total_search_words = count($search_for);
	
	foreach($search_for as $key=>$search_term) {
		$where .= "`review_title` LIKE '%$search_term%'";
		
		if($key != ($total_search_words - 1)) {
			$where .= " AND ";
		}
	}
	$value = $_POST['search_value'];
	if($value == 2){	
	$results = "SELECT * FROM `reviews` WHERE $where";
	} else {
	$results = "SELECT * FROM `reviews` WHERE `review_referral` = '$value' AND $where";
	}
	$results_num = ($results = mysql_query($results)) ? mysql_num_rows($results) : 0;
	
	if($results_num === 0) {
		return false;
	} else {
		 
		while($results_row = mysql_fetch_assoc($results)) {
			$returned_results[] = array(
								'review_title' => $results_row['review_title'],
								'review_body' => $results_row['review_body'],
								'user_id' => $results_row['user_id'],
								'user_firstname' => $results_row['user_firstname'],
								'user_lastname' => $results_row['user_lastname'],
								'review_id' => $results_row['review_id'],
								'review_body' => $results_row['review_body'],
								'review_referral' => $results_row['review_referral'],
								'rating' => $results_row['review_rating'],
								'review_date' => $results_row['review_date'],
								'review_category' => $results_row['review_category'],
								'review_url' => $results_row['review_url'],
								'referral_category' => $results_row['referral_category'],
			);
		
		}

return $returned_results;
	
	
	}
}		

?>