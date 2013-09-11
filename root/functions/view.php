<?php 

function load_view($view, $data=array())
{
	$url = "../../views/". $view .".php";
	
	if( file_exists($url) )
	{	
		
		if(is_array($data))
		{
			extract($data);
			
			require "../../views/". $view .".php";
		}
	}
	else
	{
		die("Failed to load " . $view . ".php -- Try reloading the page.");
	}
}