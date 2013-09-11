<?php

/**
 * Abstract Registry Class
 *
 * A basic template for all our registry classes.
 *
 *
 *
 * License goes here
 *
 * @author 		Lance Hasson
 * @copyright 	2012 Wordflow Inc.
 * @license 	Need license url
 */
 
abstract class registry {

	private $container = array();
	
	private function exists($key)
	{
		return (isset($this->container[$key])) ? true : false;
	}
	
	public function set($key, $value)
	{
		if(!$this->exists($key))
		{
			$this->container[$key] = $value;
		}
		else
		{
			// do some error thing here
		}
	}
	
	public function get($key)
	{
		if($this->exists($key))
		{
			return $this->container[$key];
		}
		else
		{
			// do something
		}
	}
	
	public function rename($old, $new)
	{
		if($this->exists($old) && !$this->exists($new))
		{
			$this->set($new, $this->get($new));
		}
		else
		{
			// do something
		}
	}
	
	public function delete($key)
	{
		if($this->exists($key))
		{
			unset($this->container[$key]);
		}
	}
	
	
	

}