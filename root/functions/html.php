<?php

ini_set('display_errors', 1);

class html {
	
	private static $docs = array(
		
		
		
	);
	
	private static $newLine = "\n";
	
	public static function doc($type)
	{
		if(isset(self::$docs[$type]))
		{
			echo self::$docs[$type];
		}
		else
		{
			throw new Exception("The inserted doctype could not be found!");
		}
	}
	
	public static function htm($callback)
	{
		if(is_callable($callback))
		{
			echo "<html>" . self::$newLine;
			
			call_user_func($callback);
			
			echo "</html>";
		}
		else
		{
			throw new Exception("The inserted callback into ".__METHOD__."() could not be called!");
		}
	}
	
	public static function head($callback)
	{
		if(is_callable($callback))
		{
			echo "<head>" . self::$newLine;
			
			call_user_func($callback);
			
			echo "</head>" . self::$newLine;
		}
		else
		{
			throw new Exception("The inserted callback into ".__METHOD__."() could not be called!");
		}
	}
	
	public static function meta($name, $keywords)
	{
		echo '<meta name="'.$name.'" content="'.$keywords.'"' . self::$newLine;
	}
	
	public static function link($url, $media = null)
	{
		if(is_null($media))
		{
			echo '<link rel="stylesheet" type="text/css" href="'.$url.'"' . self::$newLine;
		}
		else
		{
			echo '<link rel="stylesheet" type="text/css" href="'.$url.'" media="'.$media.'"' . self::$newLine;
		}
	}
	
	public static function title($title)
	{
		echo "<title>$title</title>" . self::$newLine;
	}


}

html::htm(function(){

	html::head(function(){
	
		html::title("Hello World");
	
	});


});