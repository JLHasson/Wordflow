<?php

 
/**
 * Security Class
 *
 * A security class used for generating csrf tokens, hashing passwords and stuff like that.
 *
 *
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Word of Mouth Inc.
 * @license 	Need license url
 */
 
 
class security {
	
	/**
	 * password_chars
	 * 
	 * @var string
	 * @access private
	 * @static
	 */
	 
	private static $password_chars = '/.abcdefghijklmnop/.qrstuv./wxyz..ABCDEFG/.HIJKLMNOPQRSTUVW/.XYZ012345/.6789';
	
	/**
	 * hash_password function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $input
	 * @return void
	 */
	 
	public static function hash_password($input)
	{
		// wow server really i have to resort to md5 cause you suck and dont have the blowfish alogrithm available...
		return md5($input);
	}

	/**
	 * check_hash function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $input
	 * @param mixed $against
	 * @return void
	 */
	 
	public static function check_hash($input, $against)
	{
		return (crypt($input, $against) == $against) ? true : false;
	}
	
	/**
	 * generate_token function.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	 
	public static function generate_token()
	{
		$time = explode(" ", microtime());
		return md5( $time[1] * (rand(0, 1000) * mt_rand(0, 1000000)) );
	}
	
	
	/**
	 * basic_sanitize function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $input
	 * @return void
	 */
	 
	public static function basic_sanitize($input)
	{
		return strip_tags(stripslashes($input));
	}
	
	/**
	 * escape function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $input
	 * @return void
	 */
	 
	public static function escape($input)
	{
		return mysqli_real_escape_string($input);
	}
	
	/**
	 * escape_sanitize function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $input
	 * @return void
	 */
	 
	public static function escape_sanitize($input)
	{
		return self::escape(self::basic_sanitize($input));
	}
}