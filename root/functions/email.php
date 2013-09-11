<?php


class email {
	
	private $person;
	
	private $sender;
	
	
	
	public function to($person)
	{
		if(is_array($person))
		{
			$this->people = implode("\r\n", $person);
		}
		else
		{
			$this->people = $people;
		}
	}


}