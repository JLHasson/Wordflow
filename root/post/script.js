(function($){


var newPost = {

	init: function(elem, options)
	{
		this.elem = elem;
		
		this.$elem = $(this.elem);
		
		this.menu  = this.$elem.find('ul li a');
		
		this.options = $.extend({}, options, $.fn.newPost.options);
		
		
		// set up the stuff we need to make it work.
		
		this.boughtlink = $(this.options.boughtLink);
		
		this.spreadlink = $(this.options.spreadLink);
		
		this.cycle();
	},
	
	cycle: function()
	{
		
	},
	
	updateTitle: function()
	{
		
	},
	
	showBoxes: function()
	{
	
	},
	
	attachClick: function()
	{
		
	},
	
	

};


$.fn.newPost = (function(options){

	return this.each(function(){
	
		var post = Object.create(newPost);
		
		post.init(this, options);
	
	});

});

$.fn.newPost.options = {};

}(jQuery));