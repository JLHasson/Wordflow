<?php

/**
 * Filter Class
 *
 * Class for filtering emails, urls, etc...
 *
 *
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word of Mouth Inc.
 * @license 	Need license url
 */

class filter {
	
	/**
	 * is_email function
	 * 
	 * @access public
	 * @static
	 * @param mixed $email
	 * @return void
	 */
	 
	public static function is_email($email)
	{
		return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
	}
	
	public static function is_url($url)
	{
		// do something
	}	
}