(function($){
	
	/* 
	 * Search Bar
	 *
	 */
	
	var selectLabel = $('.select-label'),
	    select 		= $('.search select');
	
	selectLabel.html($('.search select option:selected').val());
	select.change(function(event){
	    
	    selectLabel.html($('.search select option:selected').val());
	    
	});
	    
    
    /*
     * Header Drop Down Menu
     */
  
  	



}(jQuery));