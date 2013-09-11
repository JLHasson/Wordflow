<?php


class template {

	public function view($view, $data)
	{
		
		$this->header($data);
			
			load_view($view);
			
		$this->footer();
	}
	
	public function header($data)
	{
		load_view('header', $data);
	}
	
	public function footer()
	{
		load_view('footer');
	}
}