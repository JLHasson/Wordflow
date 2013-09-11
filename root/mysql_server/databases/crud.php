<?php

/**
 * Database CRUD
 *
 * Unfortunately because PDO is not working right now im writing this based on mysqli which sucks
 * because if PDO starts working then im going to have to rewrite this.
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word of Mouth Inc.
 * @license 	Need license url
 */


class database_crud extends pdo_database {

	private static $instance;
	
	public static function get_instance()
	{
		
		$class = __CLASS__;
		
		if(!isset(self::$instance))
		{
			self::$instance = new $class();
		}
		
		return self::$instance;
	}

	
	// create, read, update, delete
	
	public function create_table($table, $data)
	{
		if(count($data) > 0) die("Table must contain at least one field!");
		
		$sql = "CREATE TABLE :table ( ";
		
		foreach($data as $field => $type)
		{
			$sql .= $field . " " . $type . ","; 
		}
		
		$sql .= " )";
		
		return $this->query($sql, array(':table', $table));
	}
	
	
	
	
	public function create_member($firstname, $lastname, $email, $hash, $password)
	{
		$sql = "INSERT INTO `myMembers` (`firstname`, `lastname`, `email`, `email_hash`, `password`, `sign_up_date`) 
				VALUES (:firstname, :lastname, :email, :hash, :password, now())";
		
		$params = array(
			":firstname" => $firstname,
			":lastname"  => $lastname,
			":email"	 => $email,
			":hash"		 => $hash,
			":password"  => $password
		);
		
		$this->query($sql, $params);
		
		return $this;
		
	}
	
	
	
	
	public function create_comment($uid, $reviewid, $comment)
	{
		$sql = "INSERT INTO `comments` WHERE (`id`, `user_id`, `review_id`, `comment_content`, `comment_date`)
				VALUES (NULL, :user_id, :review_id, :comment, now())";
				
		$params = array(
			':user_id' 	 => $uid,
			':review_id' => $reviewid,
			':comment' 	 => $comment
		);
		
		$this->query($sql, $params);
		
		return $this;
	}
	
	public function add_friend($uid1, $uid2)
	{
		$sql = "INSERT INTO `friend` WHERE (`id`, `uid1`, `uid2`)
				VALUES (NULL, :uid1, :uid2)";
				
		$params = array(
			
			':uid1' => $uid1,
			':uid2' => $uid2,
			
		);
		
		return $this->query($sql, $params);
	}
	
	public function create_message($to, $from, $subject, $message)
	{
		$sql = "INSERT INTO `messaging` WHERE (`id`, `to_id`, `from_id`, `time_sent`, `subject`, `message`)
				VALUES (NULL, :to, :from, now(), :subject, :message";
		
		$params = array(
		
			':to' 	   => $to,
			':from'    => $from,
			':subject' => $subject,
			':message' => $message
		
		);
		
		return $this->query($sql, $params);
	}
	
	public function create_review($uid, $firstname, $lastname, $rating, $title, $review, $review_cat, $referral_cat, $optout, $url, $referral)
	{
	
		$sql = "INSERT INTO `reviews` WHERE (`id`, `user_id`, `user_firstname`, `user_lastname`, `review_rating`, `review_title`, `review_body`, `review_date`, `review_category`, `referral_category`, `optout`, `review_url`, `review_referral`)
				VALUES (NULL, :uid, :firstname, :lastname, :rating, :title, :review, now(), :review_cat, :referral_cat, :optout, :url, :referral)";
				
		$params = array(
			
			':uid' => $uid,
			':firstname' => $firstname,
			':lastname'  => $lastname,
			':rating'    => $rating,
			':title'	 => $title,
			':review'    => $review,
			':review_cat' => $review_cat,
			':referral_cat' => $referral_cat,
			':optout'  => $optout,
			
		);
	
	}
		
	public function email_exists($email)
	{
		$sql = "SELECT `id` FROM `myMembers` WHERE `email` = :email LIMIT 1";
		
		$this->query($sql, array(':email' => $email));
			
		$num = count($this->get());
		
		return ($num > 0) ? true : false;
	
	}
	
	

}