<?php

/**
 * Config
 *
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Wordflow Inc.
 * @license 	Need license url
 */
 
class config extends registry {

	public static $instance;
	
	public static function get_instance()
	{
		if(!self::$instance)
		{
			self::$instance = new config();
		}
		
		return self::$instance;
	}
	
	private function __construct() {}
	private function __clone() {}
	
	public function get_keys()
	{
		return array_keys($this->container);
	}
	
	public function get_values()
	{
		return array_values($this->container);
	}
	
}